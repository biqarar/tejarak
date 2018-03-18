<?php
namespace lib\utility\calc;
use \lib\db;

trait full
{
		/**
	 * calculate the money left to user cash
	 *
	 * @param      <type>  $_team_id  The team identifier
	 * @param      array   $_args     The arguments
	 */
	public function plan_full_break()
	{

		if(!$this->lastcalcdate)
		{
			if($this->save)
			{
				\lib\db\logs::set('invoice:team:full:current:lastcalcdate:not:found:return:false', null, $this->log_meta);
			}
			return false;
		}

		$amount = $this->old_plan_amount;

		// for the free plan
		if(!$amount)
		{
			if($this->save)
			{
				\lib\db\logs::set('invoice:team:full:amount:0:return:true', null, $this->log_meta);
			}
			return true;
		}

		$new_amount = 0;

		$count_days_left = time() - strtotime($this->lastcalcdate);

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
			if($this->save)
			{
				return true;
			}
		}
		elseif($new_amount < 0)
		{
			if($this->save)
			{
				// minus the value from user account
				// the user use largen than one month of the plan
				$transaction_set =
		        [
					'caller'         => 'invoice:team',
					'title'          => T_("Repair old invoice"),
					'user_id'        => $this->team_details['creator'],
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
		}


		/**
		 * the user not use from this plan
		 * we give all money back
		 */
		if(!$new_amount)
		{
			$new_amount = $amount;
		}

		if(!$this->save)
		{
			return $new_amount;
		}

		if($new_amount < 100)
		{
			\lib\db\logs::set('invoice:team:full:amout:<100:return:true', null, $this->log_meta);
			return true;
		}

		$invoice_title = isset($this->team_details['name']) ? $this->team_details['name'] : T_("Cancel full plan");

		$title = T_("Cancel full plan");

		$new_invoice =
		[
			'date'    => date("Y-m-d H:i:s"),
			'user_id' => $this->team_details['creator'],
			'title'   => $invoice_title,
			'total'   => $new_amount,
		];

		$creator_details = \lib\db\users::get_by_id($this->team_details['creator']);

		$meta = [];

		if($this->creator_name)
		{
			$meta['name']   = $this->creator_name;
		}

		if($this->creator_mobile)
		{
			$meta['mobile'] = $this->creator_mobile;
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
			'title'          => T_("Cancel Full paln of :team", ['team' => $this->team_details['name']]),
			'user_id'        => $this->team_details['creator'],
			'plus'           => $new_amount,
			'payment'        => null,
			'verify'         => 1,
			'type'           => 'money',
			'unit'           => 'toman',
			'date'           => date("Y-m-d H:i:s"),
			'invoice_id'     => $invoice_id,
        ];

        \lib\db\transactions::set($transaction_set);

        $this->log_meta['meta']['debug'] = \lib\notif::get();

		if(\lib\engine\process::status())
		{
			\lib\db\logs::set('invoice:team:back:full:money:transaction:set', null, $this->log_meta);
			return true;
		}
		\lib\db\logs::set('invoice:team:error:back:full:end', null, $this->log_meta);
		return false;

	}


	/**
	 * Makes a full invoice.
	 *
	 * @param      <type>   $_team_id  The team identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function make_full_invoice()
	{

		$amount = $this->new_plan_amount;

		if(!$this->save)
		{
			return $amount;
		}

		// for the free plan
		if(!$amount)
		{
			\lib\db\logs::set('invoice:team:full:make:amount:0:return:true', null, $this->log_meta);
			return true;
		}

        // get user budget
        $user_budget = \lib\db\transactions::budget($this->team_details['creator'], ['unit' => 'toman']);

        if($user_budget && is_array($user_budget))
        {
        	$user_budget = array_sum($user_budget);
        }

        if(intval($user_budget) < intval($amount))
        {
			\lib\db\logs::set('invoice:team:full:money>credit', null, $this->log_meta);
        	\lib\notif::error(T_("Your credit is less than amount of this plan, please charge your account"));
        	return false;
        }

       	$invoice_title = isset($this->team_details['name']) ? $this->team_details['name'] : T_("Active Full plan");

		$title = T_("Active Full plan");

		$meta = [];

		$new_invoice =
		[
			'date'    => date("Y-m-d H:i:s"),
			'user_id' => $this->team_details['creator'],
			'title'   => $invoice_title,
			'total'   => $amount,
		];

		if($this->creator_name)
		{
			$meta['name']   = $this->creator_name;
		}

		if($this->creator_mobile)
		{
			$meta['mobile'] = $this->creator_mobile;
		}

		if(!empty($meta))
		{
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

        if($this->notify)
        {
	        $notify_text = T_("You have new invoice for :team by amount :amount :unit",
			[
				'team'   => $this->team_details['name'],
				'amount' => \lib\utility\human::number(number_format($amount), \lib\language::current()),
				'unit'   => T_("toman"),
			]);

			// save notification to send to user
			$notify_set =
	        [
				'to'      => $this->team_details['creator'],
				'content' => $notify_text,
				'cat'     => 'invoice',
	        ];

	        \lib\db\notifications::set($notify_set);
        }

		$transaction_set =
        [
			'caller'          => 'invoice:team',
			'title'           => T_("Choose Full paln of :team", ['team' => $this->team_details['name']]),
			'user_id'         => $this->team_details['creator'],
			'minus'           => $amount,
			'payment'         => null,
			'related_foreign' => 'teams',
			'related_id'      => $this->team_id,
			'verify'          => 1,
			'type'            => 'money',
			'unit'            => 'toman',
			'date'            => date("Y-m-d H:i:s"),
			'invoice_id'      => $invoice_id,
        ];

        \lib\db\transactions::set($transaction_set);

        if(\lib\engine\process::status())
        {
        	return true;
        }
        return false;
	}
}
?>