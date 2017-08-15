<?php
namespace content_a\billing;
use \lib\utility;
use \lib\debug;
use \lib\utility\payment;

class model extends \mvc\model
{
	public static $support_bank =
	[
		'zarinpal',
		// 'melli',
		'parsian',
		// 'mellat',
		// 'saman',
		// 'tejarat',
	];


	/**
	 * the user id
	 *
	 * @var        <type>
	 */
	public $user_id = null;


	/**
	 * get billing data to show
	 */
	public function get_billing($_args)
	{
		if(!$this->login())
		{
			return false;
		}
		$meta            = [];
		$this->user_id   = $this->login('id');
		$meta['user_id'] = $this->user_id;
		// $meta['admin']   = false ;
		$meta['verify'] = 1;
		$billing_history = \lib\db\transactions::search(null, $meta);
		return $billing_history;
	}

	/**
	 * post data and update or insert billing data
	 */
	public function post_billing()
	{
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
}
?>