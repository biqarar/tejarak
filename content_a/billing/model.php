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
	 * PAYMENT DATA
	 *
	 * @var        array
	 */
	public static $PAYMENT_DATA = [];

	/**
	 * the user id
	 *
	 * @var        <type>
	 */
	public $user_id = null;

	use tools\data;
	use tools\pay;
	use tools\unit;


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
		$meta['admin']   = false ;

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
			return debug::error(T_("You must login to pay amount"));
		}

		$this->user_id = $this->login('id');

		if(!$this->user_unit())
		{
			return;
		}

		if(utility::post('bank'))
		{
			if(!in_array(mb_strtolower(utility::post('bank')), self::$support_bank))
			{
				debug::error(T_("This gateway is not supported by Sarshomar"));
				return false;
			}

			if(!utility::post('amount'))
			{
				debug::error(T_("Amount not set"), 'amount', 'arguments');
				return false;
			}

			return $this->pay();
		}

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
			$this->save_transaction($amount);
			return debug::true(T_("Your account charge :amount", ['amount' => $amount]));
		}
		else
		{
			return debug::error(T_("Invalid promo code"), 'promo', 'arguments');
		}
	}


	/**
	 * Posts a verify.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_verify()
	{
		return $this->get_verify();
	}


	/**
	 * Gets the verify.
	 *
	 * @return     <type>  The verify.
	 */
	public function get_verify()
	{
		$url = \lib\router::get_url();

		$this->controller->display = false;

		if(preg_match("/zarinpal/", $url))
		{
			return $this->zarinpal_verify();
		}
		elseif(preg_match("/parsian/", $url))
		{
			$this->parsian_verify();
			$this->redirector($this->url('baseFull'). '/billing')->redirect();
		}
	}
}
?>