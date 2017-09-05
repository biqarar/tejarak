<?php
namespace content_s\billing;
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
				$this->check_promo();
			}
			else
			{
				debug::error(T_("Invalid promo code"), 'promo', 'arguments');
				return false;
			}
		}
	}



	public function check_promo()
	{
		$promo     = utility::post('promo');
		$amount    = 0;
		$user_code = null;
		$user_ref  = null;

		$log_meta =
        [
        	'data' => null,
        	'meta' =>
        	[
				'user'    => $this->login('id'),
				'ref'     => $user_ref,
				'post'    => utility::post(),
				'session' => $_SESSION,
        	],
        ];

		if(!preg_match("/^ref\_([A-Za-z0-9]+)$/", $promo, $split))
		{
			\lib\db\logs::set('ref:reqular:invalid', $this->login('id'), $log_meta);
			debug::error(T_("Invalid promo code"), 'promo', 'arguments');
			return false;
		}
		if(isset($split[1]))
		{
			$user_code = $split[1];
			$user_ref = \lib\utility\shortURL::decode($user_code);
			if(!$user_ref)
			{
				\lib\db\logs::set('ref:shortURL:invalid', $this->login('id'), $log_meta);
				debug::error(T_("Invalid promo code"), 'promo', 'arguments');
				return false;
			}
		}

		if(intval($this->login('id')) === intval($user_ref))
		{
			\lib\db\logs::set('ref:yourself', $this->login('id'), $log_meta);
			debug::error(T_("You try to referral yourself!"), 'promo', 'arguments');
			return false;
		}

		if($this->login('ref'))
		{
			\lib\db\logs::set('ref:full', $this->login('id'), $log_meta);
			debug::error(T_("You have ref. can not set another ref"), 'promo', 'arguments');
			return false;
		}

		$check_user_ref = \lib\db\users::get_by_id($user_ref);

		if(!isset($check_user_ref['id']))
		{
			\lib\db\logs::set('ref:user:not:found', $this->login('id'), $log_meta);
			debug::error(T_("Ref not found"), 'promo', 'arguments');
			return false;
		}

		\lib\db\users::update(['user_ref' => $user_ref], $this->login('id'));
		$_SESSION['user']['ref'] = $user_ref;

		$transaction_set =
        [
			'caller'          => 'promo:ref',
			'title'           => T_("Promo for using ref"),
			'user_id'         => $this->login('id'),
			'plus'            => 10 * 1000,
			'payment'         => null,
			'related_foreign' => 'users',
			'related_id'      => $user_ref,
			'verify'          => 1,
			'type'            => 'money',
			'unit'            => 'toman',
			'date'            => date("Y-m-d H:i:s"),
        ];

        \lib\db\transactions::set($transaction_set);


        $notify_ref =
        [
			'to'      => $user_ref,
			'cat'     => 'ref',
			'content' => T_("Someone used your ref link in her referral"),
        ];
        \lib\db\notifications::set($notify_ref);


        $notify_ref =
        [
			'to'      => $this->login('id'),
			'cat'     => 'useref',
			'content' => T_("Your are using referral program and your account was charged"),
        ];
        \lib\db\notifications::set($notify_ref);


        if(debug::$status)
        {
        	\lib\db\logs::set('user:use:ref', $this->login('id'), $log_meta);
        	\lib\db\logs::set('user:was:ref', $user_ref, $log_meta);
        	debug::true(T_("Your ref was set and your account was charge"));
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