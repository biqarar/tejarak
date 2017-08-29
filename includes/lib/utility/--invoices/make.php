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

		if(isset($_args['current']['lastcalcdate']))
		{
			$start_plan = $_args['current']['lastcalcdate'];
		}
		else
		{
			\lib\db\logs::set('invoice:team:current:lastcalcdate:not:found:return:false', null, $log_meta);
			return false;
		}

		$used_time = time() - strtotime($start_plan);

		$used_time = $used_time / ( 60 * 60 );

		if($used_time < 1)
		{
			$used_time = 0;
		}

		$active_per_hour = 10 / 30 / 24;

		$active_time = $active_per_hour * $used_time;

		$count_use = round(($used_time));

		if($active_time < 1)
		{
			$count_use = round($used_time * 60);
			$invoice_unit_title = T_("Minuts");
		}
		elseif($active_time < 24)
		{
			$invoice_unit_title = T_("Hour");
		}
		else
		{
			$count_use = round(($used_time / 24));
			$invoice_unit_title = T_("Day");
		}

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

		$log_meta['meta']['active_user'] = $count_active_user;

		$count_active_user = count($count_active_user);

		$count_days_use = time() - strtotime($start_plan);

		$count_days_use = $count_days_use / ( 60 * 60 * 24);

		$new_amount = ($count_active_user * $amount * $count_days_use) / 30;

		$new_amount = floor($new_amount / 100) * 100;

		if($new_amount < 100)
		{
			\lib\db\logs::set('invoice:team:amout:<100:return:true', null, $log_meta);
			$new_amount = 0;
			return true;
		}

		if(!$new_amount)
		{
			return true;
		}

		if(!isset(self::$team_details['creator']))
		{
			\lib\db\logs::set('invoice:team:cteator:not:found:return:false', null, $log_meta);
			return false;
		}

		$invoice_title = isset(self::$team_details['name']) ? self::$team_details['name'] : T_("Change plan");

		$title = T_("Using :d :v From plan :p By :c active member",
		[
			'd' => \lib\utility\human::number($count_use,\lib\define::get_language()),
			'v' => $invoice_unit_title,
			'p' => T_(self::$old_plan_name),
			'c' => \lib\utility\human::number($count_active_user, \lib\define::get_language()),
		]);

		$new_invoice =
		[
			'date'         => date("Y-m-d H:i:s"),
			'user_id'      => self::$team_details['creator'],
			'title'        => $invoice_title,
			'total'        => $new_amount,
			'count_detail' => 1,
		];

		$meta                      = [];
		$meta['count_use']         = $count_use;
		$meta['unit_use']          = $invoice_unit_title;
		$meta['plan']              = self::$old_plan_name;
		$meta['count_active_user'] = $count_active_user;

		$creator_details = \lib\db\users::get_by_id(self::$team_details['creator']);

		if(isset($creator_details['user_displayname']) && isset($creator_details['user_mobile']))
		{
			$meta['name']   = $creator_details['user_displayname'];
			$meta['mobile'] = $creator_details['user_mobile'];
			$meta['args']   = func_get_args();

		}

		if(!empty($meta))
		{
			$new_invoice['meta'] = json_encode($meta, JSON_UNESCAPED_UNICODE);
		}

		if($new_amount > 499000)
		{
			\lib\db\logs::set('invoice:team:>499:we:get:499', null, $log_meta);
			$new_amount = 499000;
		}

		$new_invoice_detail =
		[
			'title'      => $title,
			'price'      => $new_amount,
			'count'      => 1,
			'total'      => $new_amount,
		];

		$invoice = new \lib\db\invoices;

        $invoice->add($new_invoice);

        $invoice->add_child($new_invoice_detail);

        $invoice_id = $invoice->save();

        $transaction_set =
        [
			'caller'         => 'invoice:team',
			'title'          => T_("Invoice :team", ['team' => self::$team_details['name']]),
			'user_id'        => self::$team_details['creator'],
			'minus'          => $new_amount,
			'payment'        => null,
			'verify'         => 1,
			'type'           => 'money',
			'unit'           => 'toman',
			'date'           => date("Y-m-d H:i:s"),
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