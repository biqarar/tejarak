<?php
namespace content_a\notifications;
use \lib\utility;
use \lib\debug;
use \lib\utility\payment;

class model extends \content_a\main\model
{
	public $user_id = null;
	/**
	 * get notifications data to show
	 */
	public function get_notifications($_args)
	{
		if(!$this->login())
		{
			return false;
		}
		$meta            = [];
		$this->user_id   = $this->login('id');
		$meta['user_id'] = $this->user_id;
		$meta['sort']    = 'id';
		$meta['order']   = 'desc';
		$notify = \lib\db\notifications::search(null, $meta);
		$cat_list = \lib\option::config('notification', 'cat');

		if(is_array($notify))
		{
			foreach ($notify as $key => $value)
			{
				if(isset($value['category']) && isset($cat_list[$value['category']]))
				{
					if(isset($cat_list[$value['category']]['title']))
					{
						$notify[$key]['cat_title'] =  $cat_list[$value['category']]['title'];
					}

					if(isset($cat_list[$value['category']]['btn']) && is_array($cat_list[$value['category']]['btn']))
					{
						$notify[$key]['btn'] = [];
						foreach ($cat_list[$value['category']]['btn'] as $k => $v)
						{
							$notify[$key]['btn'][$k] = T_($v);
						}
					}
				}
			}
		}

		return $notify;
	}

	/**
	 * post data and update or insert notifications data
	 */
	public function post_notifications()
	{
		var_dump(utility::post());exit();
		if(!$this->login())
		{
			debug::error(T_("You must login to pay amount"));
			return false;
		}

		$this->user_id = $this->login('id');

		if(utility::post('bank'))
		{
			if(!in_array(mb_strtolower(utility::post('bank')), self::$support_bank))
			{
				debug::error(T_("This gateway is not supported by tejarak"));
				return false;
			}

			if(!utility::post('amount') || !is_numeric(utility::post('amount')))
			{
				debug::error(T_("Amount not set"), 'amount', 'arguments');
				return false;
			}

			switch (mb_strtolower(utility::post('bank')))
			{
				case 'zarinpal':
					\lib\utility\payment\pay::zarinpal($this->user_id, utility::post('amount'), ['turn_back' => $this->url('full')]);
					return;
					break;

				case 'parsian':
					\lib\utility\payment\pay::parsian($this->user_id, utility::post('amount'), ['turn_back' => $this->url('full')]);
					return;
					break;

				default:
					return false;
					break;
			}
		}

		if(utility::post('type') === 'promo')
		{
			if(utility::post('promo'))
			{

				$amount = 0;
				switch (utility::post('promo'))
				{
					// case '$1000$':
					// 	$amount = 1000;
					// 	break;

					// case '$2000$':
					// 	$amount = 2000;
					// 	break;

					// case '$$':
					// 	$amount = 100000;
					// 	break;
					default:
						return debug::error(T_("Invalid promo code"), 'promo', 'arguments');
						break;
				}

				return debug::true(T_("Your account charge :amount", ['amount' => $amount]));
			}
			else
			{
				return debug::error(T_("Invalid promo code"), 'promo', 'arguments');
			}
		}
	}


	/**
	 * use usage
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function usage()
	{

		if(isset($_SESSION['usage_team']) && isset($_SESSION['usage_team_time']))
		{
			if(time() - strtotime($_SESSION['usage_team_time']) > (60*60))
			{
				$_SESSION['usage_team'] = $this->run_usage();
				$_SESSION['usage_team_time'] = date("Y-m-d H:i:s");
			}
		}
		else
		{
			$_SESSION['usage_team'] = $this->run_usage();
			$_SESSION['usage_team_time'] = date("Y-m-d H:i:s");
		}

		return $_SESSION['usage_team'];
	}


	/**
	 * { function_description }
	 */
	public function run_usage()
	{
		if(!$this->login())
		{
			return false;
		}

		$user_id = $this->login('id');

		$all_creator_team = \lib\db\teams::get(['creator' => $user_id]);

		$total_usage = 0;
		if(is_array($all_creator_team))
		{
			foreach ($all_creator_team as $key => $value)
			{
				if(isset($value['id']))
				{
					$calc = new \lib\utility\calc($value['id']);
					$calc->save(false);
					$calc->notify(false);
					$calc->type('calc');
					$total_usage += $calc->calc();
				}
			}
		}
		return $total_usage;
	}
}
?>