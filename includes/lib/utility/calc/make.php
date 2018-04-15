<?php
namespace lib\utility\calc;
use \lib\db;

trait make
{
	/**
	 * Makes an invoice.
	 *
	 * @param      <type>  $_team_id  The team identifier
	 * @param      array   $_args     The arguments
	 */
	public function make_plan_invoice()
	{

		if(!$this->creator)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:cteator:not:found:return:false', $this->user_id, $this->log_meta);
			}
			return false;
		}

		$amount = $this->old_plan_amount;

		// for the free plan
		if(!$amount)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:amount:0:return:true', $this->user_id, $this->log_meta);
			}
			return true;
		}

		if(!$this->lastcalcdate)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:current:lastcalcdate:not:found:return:false', $this->user_id, $this->log_meta);
			}
			return false;
		}

		$used_time = time() - strtotime($this->lastcalcdate);

		$used_time = $used_time / ( 60 * 60 );

		if($used_time < 1)
		{
			$used_time = 0;
		}

		$active_per_hour = 10 / 30 / 24;

		$active_time = $active_per_hour * $used_time;
		$active_time = floor($active_time);

		if($used_time < 1)
		{
			$count_use = round($used_time * 60);
			$invoice_unit_title = T_("Minuts");
		}
		elseif($used_time < 24)
		{
			$count_use = round(($used_time));
			$invoice_unit_title = T_("Hour");
		}
		else
		{
			$count_use = round(($used_time / 24));
			$invoice_unit_title = T_("Day");
		}

		$active_user_period =
		[
			'team_id'     => $this->team_id,
			'start'       => $this->lastcalcdate,
			'end'         => date("Y-m-d H:i:s"),
			'active_time' => $active_time,
		];

		$count_active_user = \lib\db\hours::active_user_period($active_user_period);

		if(!$count_active_user)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:active:user:0:return:true', $this->user_id, $this->log_meta);
				return true;
			}
			else
			{
				return 0;
			}
		}

		$this->log_meta['meta']['active_user'] = $count_active_user;

		$count_active_user = count($count_active_user);

		$count_days_use = time() - strtotime($this->lastcalcdate);

		$count_days_use = $count_days_use / ( 60 * 60 * 24);

		$new_amount = ($count_active_user * $amount * $count_days_use) / 30;

		$new_amount = floor($new_amount / 100) * 100;

		if($new_amount < 100)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:amout:<100:return:true', $this->user_id, $this->log_meta);
				return true;
			}
			else
			{
				return 0;
			}
		}

		if(!$new_amount)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:!amout:return:true', $this->user_id, $this->log_meta);
				return true;
			}
			else
			{
				return 0;
			}
		}


		$invoice_title = isset($this->team_details['name']) ? $this->team_details['name'] : T_("Change plan");

		$title = T_("Using :d :v From plan :p By :c active member",
		[
			'd' => \dash\utility\human::number($count_use,\dash\language::current()),
			'v' => $invoice_unit_title,
			'p' => T_($this->old_plan_name),
			'c' => \dash\utility\human::number($count_active_user, \dash\language::current()),
		]);

		$this->count_active_user = $count_active_user;
		$this->active_time       = $active_time;
		$new_invoice =
		[
			'date'         => date("Y-m-d H:i:s"),
			'user_id'      => $this->team_details['creator'],
			'title'        => $invoice_title,
			'total'        => $new_amount,
			'count_detail' => 1,
		];

		$meta                      = [];
		$meta['count_use']         = $count_use;
		$meta['unit_use']          = $invoice_unit_title;
		$meta['plan']              = $this->old_plan_name;
		$meta['count_active_user'] = $count_active_user;

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

		if($new_amount > 499000)
		{
			if($this->save)
			{
				\dash\db\logs::set('invoice:team:>499:we:get:499', $this->user_id, $this->log_meta);
			}
			$new_amount = 499000;
		}

		// if save is false return new amount
		if(!$this->save)
		{
			return $new_amount;
		}

		$new_invoice_detail =
		[
			'title'      => $title,
			'price'      => $new_amount,
			'count'      => 1,
			'total'      => $new_amount,
		];

		$invoice = new \dash\db\invoices;

        $invoice->add($new_invoice);

        $invoice->add_child($new_invoice_detail);

        $invoice_id = $invoice->save();

        if($this->notify)
        {
	        $notify_text = T_("You have new invoice for :team by amount :amount :unit",
			[
				'team'   => $this->team_details['name'],
				'amount' => \dash\utility\human::number(number_format($amount), \dash\language::current()),
				'unit'   => T_("toman"),
			]);

			// save notification to send to user
			$notify_set =
	        [
				'to'      => $this->team_details['creator'],
				'content' => $notify_text,
				'cat'     => 'invoice',
	        ];

	        \dash\db\notifications::set($notify_set);
        }

        $transaction_set =
        [
			'caller'         => 'invoice:team',
			'title'          => T_("Invoice :team", ['team' => $this->team_details['name']]),
			'user_id'        => $this->creator,
			'minus'          => $new_amount,
			'payment'        => null,
			'verify'         => 1,
			'type'           => 'money',
			'unit'           => 'toman',
			'date'           => date("Y-m-d H:i:s"),
			'invoice_id'     => $invoice_id,
        ];

        \dash\db\transactions::set($transaction_set);

        $this->log_meta['meta']['debug'] = \dash\notif::get();

		if(\dash\engine\process::status())
		{
			\dash\db\logs::set('invoice:team:set:transaction:set', $this->user_id, $this->log_meta);
			return true;
		}

		\dash\db\logs::set('invoice:team:error:end', $this->user_id, $this->log_meta);
		return false;
	}
}
?>