<?php
namespace lib\utility\invoices;
use \lib\db;

trait full
{
		/**
	 * calculate the money left to user cash
	 *
	 * @param      <type>  $_team_id  The team identifier
	 * @param      array   $_args     The arguments
	 */
	public static function plan_full_break($_team_id, $_args = [])
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

		if(isset($_args['current']['lastcalcdate']))
		{
			$start_plan = $_args['current']['lastcalcdate'];
		}
		else
		{
			\lib\db\logs::set('invoice:team:full:current:lastcalcdate:not:found:return:false', null, $log_meta);
			return false;
		}

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
			\lib\db\logs::set('invoice:team:full:amount:0:return:true', null, $log_meta);
			return true;
		}

		$new_amount = 0;

		$count_days_left = time() - strtotime($start_plan);

		$count_days_left_hour = $count_days_left / ( 60 * 60 );

		if($count_days_left_hour < 1)
		{
			$count_days_left_hour = 0;
		}

		$price_every_hour = $amount / 30 / 24;

		$new_amount = $price_every_hour * $count_days_left_hour;

		$new_amount = $amount - $new_amount;

		$new_amount = floor($new_amount / 100) * 100;

		if($new_amount > 0)
		{
			// plus the new amount to user account
		}
		elseif($new_amount === 0)
		{
			return true;
		}
		elseif($new_amount < 0)
		{
			// minus the value from user account
			// the user use largen than one month of the plan
			$transaction_set =
	        [
				'caller'         => 'invoice:team',
				'title'          => T_("Repair old invoice"),
				'user_id'        => self::$team_details['creator'],
				'minus'          => abs($new_amount),
				'payment'        => null,
				'verify'         => 1,
				'type'           => 'money',
				'unit'           => 'toman',
				'date'           => date("Y-m-d H:i:s"),
	        ];

	        \lib\db\transactions::set($transaction_set);

			return true;
		}


		/**
		 * the user not use from this plan
		 * we give all money back
		 */
		if(!$new_amount)
		{
			$new_amount = $amount;
		}


		if($new_amount < 100)
		{
			\lib\db\logs::set('invoice:team:full:amout:<100:return:true', null, $log_meta);
			return true;
		}

		$invoice_title = isset(self::$team_details['name']) ? self::$team_details['name'] : T_("Cancel full plan");

		$title = T_("Cancel full plan");

		$new_invoice =
		[
			'date'    => date("Y-m-d H:i:s"),
			'user_id' => self::$team_details['creator'],
			'title'   => $invoice_title,
			'total'   => $new_amount,
		];

		$creator_details = \lib\db\users::get(self::$team_details['creator']);

		$meta = [];

		if(isset($creator_details['user_displayname']) && isset($creator_details['user_mobile']))
		{
			$meta['name']   = $creator_details['user_displayname'];
			$meta['mobile'] = $creator_details['user_mobile'];
		}

		if(!empty($meta))
		{
			$new_invoice['meta'] = json_encode($meta, JSON_UNESCAPED_UNICODE);
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
			'title'          => T_("Cancel Full paln of :team", ['team' => self::$team_details['name']]),
			'user_id'        => self::$team_details['creator'],
			'plus'           => $new_amount,
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
			\lib\db\logs::set('invoice:team:back:full:money:transaction:set', null, $log_meta);
			return true;
		}
		\lib\db\logs::set('invoice:team:error:back:full:end', null, $log_meta);
		return false;

	}


	/**
	 * Makes a full invoice.
	 *
	 * @param      <type>   $_team_id  The team identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function make_full_invoice($_team_id, $_args)
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

		if(isset($_args['current']['start']))
		{
			$start_plan = $_args['current']['start'];
		}
		else
		{
			\lib\db\logs::set('invoice:team:full:make:current:start:not:found:return:false', null, $log_meta);
			return false;
		}

		$new_plan_detail = \lib\utility\plan::get_detail(self::$new_plan_code);
		if(isset($new_plan_detail['amount']))
		{
			$amount = floatval($new_plan_detail['amount']);
		}
		else
		{
			$amount = 0;
		}
		// for the free plan
		if(!$amount)
		{
			\lib\db\logs::set('invoice:team:full:make:amount:0:return:true', null, $log_meta);
			return true;
		}

        // get user budget
        $user_budget = \lib\db\transactions::budget(self::$team_details['creator'], ['unit' => 'toman']);

        if($user_budget && is_array($user_budget))
        {
        	$user_budget = array_sum($user_budget);
        }

        if(intval($user_budget) < intval($amount))
        {
			\lib\db\logs::set('invoice:team:full:money>credit', null, $log_meta);
        	\lib\debug::error(T_("Your credit is less than amount of this plan, please charge your account"));
        	return false;
        }

       	$invoice_title = isset(self::$team_details['name']) ? self::$team_details['name'] : T_("Active Full plan");

		$title = T_("Active Full plan");

		$new_invoice =
		[
			'date'    => date("Y-m-d H:i:s"),
			'user_id' => self::$team_details['creator'],
			'title'   => $invoice_title,
			'total'   => $amount,
		];

		$creator_details = \lib\db\users::get(self::$team_details['creator']);

		if(isset($creator_details['displayname']) && isset($creator_details['user_mobile']))
		{
			$meta =
			[
				'name'   => $creator_details['user_displayname'],
				'mobile' => $creator_details['user_mobile'],
			];

			$new_invoice['meta'] = json_encode($meta, JSON_UNESCAPED_UNICODE);
		}

		$new_invoice_detail =
		[
			'title'      => $title,
			'price'      => $amount,
			'count'      => 1,
			'total'      => $amount,
		];

        $invoice = new \lib\db\invoices;
        $invoice->add($new_invoice);
        $invoice->add_child($new_invoice_detail);
        $invoice_id = $invoice->save();

		$transaction_set =
        [
			'caller'          => 'invoice:team',
			'title'           => T_("Choose Full paln of :team", ['team' => self::$team_details['name']]),
			'user_id'         => self::$team_details['creator'],
			'minus'           => $amount,
			'payment'         => null,
			'related_foreign' => 'teams',
			'related_id'      => self::$team_id,
			'verify'          => 1,
			'type'            => 'money',
			'unit'            => 'toman',
			'date'            => date("Y-m-d H:i:s"),
			'invoice_id'      => $invoice_id,
        ];

        \lib\db\transactions::set($transaction_set);

        if(\lib\debug::$status)
        {
        	return true;
        }
        return false;

	}
}
?>