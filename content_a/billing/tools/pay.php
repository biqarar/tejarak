<?php
namespace content_a\billing\tools;
use \lib\utility;
use \lib\debug;
use \lib\utility\payment;

trait pay
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_bank  The bank
	 */
	public static function payment_data($_bank)
	{

		if(!isset(self::$PAYMENT_DATA[$_bank]))
		{
			$where =
			[
				'user_id'       => null,
				'post_id'       => null,
				'option_cat'    => 'payment_data',
				'option_key'    => $_bank,
				'option_status' => 'enable',
				'limit'			=> 1,
			];
			$result = \lib\db\options::get($where);
			if(isset($result['value']))
			{
				self::$PAYMENT_DATA[$_bank] = $result;
			}
		}

		if(isset(self::$PAYMENT_DATA[$_bank]))
		{
			return self::$PAYMENT_DATA[$_bank];
		}
		return [];
	}


	/**
	 * pay amount
	 */
	public function pay()
	{
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input'   => utility::post(),
				'session' => $_SESSION,
			],
		];

		$host  = Protocol."://" . \lib\router::get_root_domain();
		$lang = \lib\define::get_current_language_string();
		$host .= $lang;

		$amount  = utility::post('amount');
		$log_meta['data'] = $amount;

		if(!is_numeric($amount) || intval($amount) < 1)
		{
			\lib\db\logs::set('user:billing:charge:error:invalid:amount', $this->user_id, $log_meta);
			debug::error(T_("Invalid amount"), 'amount', 'arguments');
			return false;
		}

		if(mb_strtolower(utility::post('bank')) == 'zarinpal')
		{
			self::$zarinpal['Description'] = T_("Charge Tejarak");

			$host .= '/a/billing/verify/zarinpal';

			self::$zarinpal['CallbackURL'] = $host;

			self::$zarinpal['Amount'] = $amount;
			$_SESSION['Amount']       = $amount;
			\lib\db\logs::set('user:billing:charge:zarinpal', $this->user_id, $log_meta);
			\lib\utility\payment\zarinpal::$save_log = true;
			\lib\utility\payment\zarinpal::$user_id  = $this->user_id;
			return \lib\utility\payment\zarinpal::pay(self::$zarinpal);
		}
		elseif(mb_strtolower(utility::post('bank')) == 'parsian')
		{
			$host                         .= '/a/billing/verify/parsian';
			self::$parsian['CallbackUrl'] = $host;
			self::$parsian['Amount']      = $amount;
			self::$parsian['OrderId']     = time() + intval($this->user_id) + rand(10, 9999);
			\lib\utility\payment\parsian::$save_log = true;
			\lib\utility\payment\parsian::$user_id  = $this->user_id;
			return \lib\utility\payment\parsian::pay(self::$parsian);
		}
	}

	/**
	 * check zarinpal verify
	 */
	public function zarinpal_verify()
	{

		$new_url = $this->view()->url->base;
		$new_url .= '/a/billing';
		debug::msg('direct', true);

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input'   => utility::get(),
				'session' => $_SESSION,
			],
		];

		if(!$this->login())
		{
			\lib\db\logs::set('user:billing:verify:not:login', null, $log_meta);
			debug::error(T_("You must login to load this page"));
			$this->redirector($new_url);
			return;
		}

		$Authority = utility::get("Authority");
		$Status    = utility::get("Status");
		$log_caller = \lib\db\logitems::caller('payment:zarinpal:redirect');
		$log_where =
		[
			'logitem_id' => $log_caller,
			'log_data'   => $Authority,
			'user_id'    => $this->login('id'),
			'log_status' => 'enable',
		];
		$saved_log = \lib\db\logs::get($log_where);

		if(count($saved_log) === 1 && isset($saved_log[0]['id']))
		{
			// expire log
			\lib\db\logs::update(['log_status' => 'expire'], $saved_log[0]['id']);
		}
		elseif(!$saved_log || empty($saved_log))
		{
			\lib\db\logs::set('user:billing:verify:log:not:save', $this->login('id'), $log_meta);
			debug::error(T_("What happend?"));
			$this->redirector($new_url);
			return;
		}
		else
		{
			\lib\db\logs::set('user:billing:verify:log:error', $this->login('id'), $log_meta);
			debug::error(T_("What happend?, more than one zarinpal request!"));
			$this->redirector($new_url);
			return;
		}

		$url_bank = \lib\router::get_url(2);
		if(!in_array($url_bank, self::$support_bank))
		{
			\lib\db\logs::set('user:billing:verify:invalid:bank', $this->login('id'), $log_meta);
			\lib\error::page(T_("Invalid bank"));
		}

		if($url_bank == 'zarinpal')
		{
			$_SESSION['operation'] = false;
			$ok                    = true;

			if(utility::get('Authority') && utility::get('Status'))
			{
				$check_verify              = self::$zarinpal;
				$check_verify['Authority'] = $Authority;
				$check_verify['Status']    = $Status;
				if(isset($_SESSION['Amount']))
				{
					$amount = $check_verify['Amount'] = $_SESSION['Amount'];
				}
				else
				{
					\lib\db\logs::set('user:billing:verify:amount:not:found', $this->login('id'), $log_meta);
					debug::error(T_("Amount not found"));
					$ok = false;
				}

				if($ok)
				{
					\lib\utility\payment\zarinpal::$save_log = true;
					\lib\utility\payment\zarinpal::$user_id = $this->login('id');
					$check = payment\zarinpal::verify($check_verify);

					if($check && debug::$status)
					{
						\lib\db\logs::set('user:billing:verify:successful', $this->login('id'), $log_meta);

						// $gift = \lib\utility\gift::gift((float) $amount);
						// $check_gift = floatval($gift) - floatval($amount);
						// if($check_gift)
						// {
						// 	\lib\db\logs::set('user:billing:need:gift', $this->login('id'), $log_meta);
						// }

						\lib\db\transactions::set('real:charge:toman', $this->login('id'), ['plus' => $amount]);
						debug::true(T_("Payment operation was successfull and :amount :unit added to your cash", ['amount' => $amount, 'unit' => T_('toman')]));
						$_SESSION['operation'] = true;
					}
				}
			}
		}

		$this->redirector($new_url);
	}

	/**
	 * check zarinpal verify
	 */
	public function parsian_verify()
	{
		$check_url = payment\parsian::check_url(self::$parsian);
		if($check_url)
		{
			$amount = isset($_SESSION['Amount']) ? $_SESSION['Amount'] : 0;

			\lib\db\transactions::set('real:charge:toman', $this->login('id'), ['plus' => $amount]);
			if(debug::$status)
			{
				debug::true(T_("Payment operation was successfull and :amount :unit added to your cash", ['amount' => $amount, 'unit' => T_('toman')]));
				$_SESSION['operation'] = true;
			}

		}
	}
}
?>