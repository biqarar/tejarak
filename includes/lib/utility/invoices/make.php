<?php
namespace lib\utility\invoices;
use \lib\db;

trait make
{
	/**
	 * Makes an invoice.
	 *
	 * @param      <type>  $_team_id  The team identifier
	 * @param      array   $_args     The arguments
	 */
	public static function make_plan_invoice($_team_id, $_args = [])
	{
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'args'         => func_get_args(),
				'session'      => $_SESSION,
				'team_details' => self::$team_details,
			]
		];


		$old_plan_detail = \lib\utility\plan::get_detail(self::$old_plan_code);
		if(isset($old_plan_detail['amount']))
		{
			$amount = floatval($old_plan_detail['amount']);
		}
		else
		{
			$amount = 0;
		}
		// for the free plan
		if(!$amount)
		{
			\lib\db\logs::set('invoice:team:amount:0:return:true', null, $log_meta);
			return true;
		}

		if(isset($_args['current']['start']))
		{
			$start_plan = $_args['current']['start'];
		}
		else
		{
			\lib\db\logs::set('invoice:team:current:start:not:found:return:false', null, $log_meta);
			return false;
		}

		$used_time = time() - strtotime($start_plan);

		if(($used_time / 60) <= 60)
		{
			$count_use = round(($used_time / 60));
			$invoice_unit_title = T_("Minuts");
			// used less than 1 hour or fix 1 hour
			$active_time = (( 10 / 30 ) / 24) / 60;
			$active_time = $active_time * ($used_time / 60);
		}
		elseif(($used_time / (60 * 60)) <= 24)
		{
			$count_use = round(($used_time / (60 * 60)));
			$invoice_unit_title = T_("Hours");
			// used less than 1 day or fix 1 day
			$active_time = ( 10 / 30 ) / 24;
			$active_time = $active_time * ($used_time / (60 * 60));
		}
		elseif(($used_time / (60 * 60)) < (24 * 30))
		{
			$count_use = round(($used_time / (60 * 60 )));
			$invoice_unit_title = T_("Days");
			// used less than 1 month
			$active_time = 10 / 30;
			$active_time = $active_time * ($used_time / (60 * 60));
		}
		else
		{
			$count_use = round(($used_time / (60 * 60 )));
			$invoice_unit_title = T_("Days");
			// used 1 month
			$active_time = 10;
			$active_time = $active_time * ($used_time / (60 * 60));
		}

		$active_time = $active_time * 60;

		$active_user_period =
		[
			'team_id'     => self::$team_id,
			'start'       => $start_plan,
			'end'         => date("Y-m-d H:i:s"),
			'active_time' => $active_time,
		];

		$count_active_user = \lib\db\hours::active_user_period($active_user_period);

		if(!$count_active_user)
		{
			\lib\db\logs::set('invoice:team:active:user:0:return:true', null, $log_meta);
			return true;
		}

		$total_amount = count($count_active_user) * $amount;

		if(!isset(self::$team_details['creator']))
		{
			\lib\db\logs::set('invoice:team:cteator:not:found:return:false', null, $log_meta);
			return false;
		}

		$invoice_title = isset(self::$team_details['name']) ? self::$team_details['name'] : T_("Change plan");

		$title = T_("Using :d :v From plan :p By :c active member",
		[
			'd' => \lib\utility\human::number($count_use,'current'),
			'v' => $invoice_unit_title,
			'p' => T_(self::$old_plan_name),
			'c' => \lib\utility\human::number($count_active_user, 'current'),
		]);

		$new_invoice =
		[
			'date'         => date("Y-m-d H:i:s"),
			'user_id'      => self::$team_details['creator'],
			'title'        => $invoice_title,
			'total'        => $amount,
			'count_detail' => 1,
		];

		$creator_details = \lib\db\users::get(self::$team_details['creator']);

		if(isset($creator_details['displayname']) && isset($creator_details['user_mobile']))
		{
			$meta =
			[
				'name'   => $creator_details['displayname'],
				'mobile' => $creator_details['user_mobile'],
			];

			$new_invoice['meta'] = json_encode($meta, JSON_UNESCAPED_UNICODE);
		}

		if($amount > 499000)
		{
			\lib\db\logs::set('invoice:team:>499:we:get:499', null, $log_meta);
			$amount = 499000;
		}

		$invoice_id = \lib\db\invoices::insert($new_invoice);

		$new_invoice_detail =
		[
			'invoice_id' => $invoice_id,
			'title'      => $title,
			'price'      => $amount,
			'count'      => 1,
			'total'      => $amount,
		];

		\lib\db\invoice_details::insert($new_invoice_detail);

        $transaction_set =
        [
			'caller'         => 'invoice:team',
			'title'          => T_("Invoice :team", ['team' => self::$team_name]),
			'user_id'        => self::$team_details['creator'],
			'minus'          => $amount,
			'payment'        => null,
			'verify'         => 1,
			'type'           => 'money',
			'unit'           => 'toman',
			'date'           => date("Y-m-d H:i:s"),
			'amount_request' => $amount,
			'invoice_id'     => $invoice_id,
        ];

        \lib\db\transactions::set($transaction_set);

        $log_meta['meta']['debug'] = \lib\debug::compile();

		if(\lib\debug::$status)
		{
			\lib\db\logs::set('invoice:team:set:transaction:set', null, $log_meta);
			return true;
		}
		\lib\db\logs::set('invoice:team:error:end', null, $log_meta);
		return false;
	}
}
?>