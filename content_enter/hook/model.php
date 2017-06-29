<?php
namespace content_enter\hook;
use \lib\utility;
use \lib\debug;

class model extends \mvc\model
{

	/**
	 * the user id
	 *
	 * @var        integer
	 */
	public $user_id = null;


	/**
	 * get user data
	 */
	public function post_user()
	{
		$this->check_api_key();

		if(debug::$status)
		{
			debug::title(T_("Operation complete"));
			debug::true(T_("Please get data from response header"));
		}
		else
		{
			debug::title(T_("Operation faild"));
		}
	}


	/**
	 * check api key and set the user id
	 */
	public function check_api_key()
	{
		$authorization = utility::header("authorization");

		if(!$authorization)
		{
			$authorization = utility::header("Authorization");
		}

		if(!$authorization)
		{
			return debug::error(T_('Authorization not found'), 'authorization', 'access');
		}

		if($authorization === '**Ermile**vHTnEoYth43MwBH7o6mPk807Tejarakf0DUbXZ7k2Bju5n^^Telegram^^')
		{
			$this->telegram_token();
		}
		else
		{
			return debug::error(T_('Invalid Authorization'), 'authorization', 'access');
		}

		$this->authorization = $authorization;
	}


	/**
	 * the api telegram token
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function telegram_token()
	{
		$telegram_id = utility::header("tg_id");
		$first_name  = utility::header('tg_first_name');
		$last_name   = utility::header('tg_last_name');
		$username    = utility::header('tg_username');
		$started     = utility::header('tg_start');
		$ref         = utility::header('tg_ref');
		$mobile      = utility::header('tg_mobile');
		$mobile      = utility\filter::mobile($mobile);

		if(!$telegram_id)
		{
			debug::error(T_("Telegram id not found"), 'telegram_id', 'header');
			return false;
		}

		if(!is_numeric($telegram_id))
		{
			debug::error(T_("Invalid telegram id"), 'telegram_id', 'header');
			return false;
		}

		$where =
		[
			'user_chat_id' => $telegram_id,
			'limit'        => 1
		];

		$exist_chart_id = \lib\db\config::public_get('users', $where);
		$exist_mobile   = false;


		if($mobile)
		{
			$exist_mobile = \lib\db\users::get_by_mobile($mobile);
		}

		if(!$exist_chart_id && !$mobile)
		{
			// calc full_name of user
			$fullName = trim($first_name. ' '. $last_name);
			$fullName = \lib\utility\safe::safe($fullName, 'sqlinjection');
			$mobile = 'tg_'. $telegram_id;

			if(mb_strlen($mobile) > 15)
			{
				debug::error(T_("Invalid telegram id leng"), 'telegram_id', 'header');
				return false;
			}

			$user = \lib\db\users::get_by_mobile($mobile);

			if(empty($user))
			{
				$port = $started ? 'telegram' : 'telegram_guest';

				$this->user_id = \lib\db\users::signup(
				[
					'mobile'      => $mobile,
					'password'    => null,
					'displayname' => $fullName,
					'ref'         => $ref,
				]);
			}
			elseif(isset($user['id']) && is_numeric($user['id']))
			{
				$this->user_id = (int) $user['id'];
			}
			else
			{
				debug::error(T_("System error"));
				return false;
			}
		}
		elseif($exist_chart_id && $exist_mobile)
		{
			if(isset($exist_mobile['id']))
			{
				$this->user_id = (int) $exist_mobile['id'];
			}
			else
			{
				debug::error(T_("System error"));
				return false;
			}
		}
		elseif($exist_chart_id && !$exist_mobile)
		{
			if(isset($exist_chart_id['id']))
			{
				if($mobile)
				{
					\lib\db\users::update(['user_mobile' => $mobile], $exist_chart_id['id']);
				}
				$this->user_id = (int) $exist_chart_id['id'];
			}
			else
			{
				debug::error(T_("System error"));
				return false;
			}
		}
		elseif(!$exist_chart_id && $exist_mobile)
		{
			if(isset($exist_mobile['id']))
			{
				if($telegram_id)
				{
					\lib\db\users::update(['user_chat_id' => $telegram_id], $exist_mobile['id']);
				}
				$this->user_id = (int) $exist_mobile['id'];
			}
			else
			{
				debug::error(T_("System error"));
				return false;
			}
		}

		if($this->user_id)
		{
			$user_data = \lib\utility\users::get($this->user_id);

			header("user_code: ". \lib\utility\shortURL::encode($this->user_id));

			if(array_key_exists('user_mobile', $user_data))
			{
				header("user_mobile: ". $user_data['user_mobile']);
			}

			if(array_key_exists('user_displayname', $user_data))
			{
				header("user_displayname: ". $user_data['user_displayname']);
			}

			if(array_key_exists('unit_id', $user_data))
			{
				header("user_unit_id: ". $user_data['unit_id']);
				if($user_data['unit_id'])
				{
					header("user_unit: ". \lib\db\units::get($user_data['unit_id'], true));
				}
			}

			if(array_key_exists('user_language', $user_data))
			{
				header("user_language: ". $user_data['user_language']);
			}
		}
		else
		{
			debug::error(T_("User id can not be find"));
			return false;
		}
	}


	/**
	 * save api log
	 *
	 * @param      boolean  $options  The options
	 */
	public function _processor($options = false)
	{
		// $log = [];

		// if(isset($_SERVER['REQUEST_URI']))
		// {
		// 	$log['url'] = $_SERVER['REQUEST_URI'];
		// }

		// if(isset($_SERVER['REQUEST_METHOD']))
		// {
		// 	$log['method'] = $_SERVER['REQUEST_METHOD'];
		// }

		// if(isset($_SERVER['REDIRECT_STATUS']))
		// {
		// 	$log['pagestatus'] = $_SERVER['REDIRECT_STATUS'];
		// }

		// $log['request']        = json_encode(\lib\utility::request(), JSON_UNESCAPED_UNICODE);
		// $log['debug']          = json_encode(\lib\debug::compile(), JSON_UNESCAPED_UNICODE);
		// $log['response']       = json_encode(\lib\debug::get_result(), JSON_UNESCAPED_UNICODE);
		// $log['requestheader']  = json_encode(\lib\utility::header(), JSON_UNESCAPED_UNICODE);
		// $log['responseheader'] = json_encode(apache_response_headers(), JSON_UNESCAPED_UNICODE);
		// $log['status']         = \lib\debug::$status;
		// $log['token']          = $this->authorization;
		// $log['user_id']        = $this->user_id;
		// $log['apikeyuserid']   = $this->parent_api_key_user_id;
		// $log['apikey']         = $this->parent_api_key;
		// $log['clientip']       = ClientIP;
		// $log['visit_id']       = null;

		// $log                   = \lib\utility\safe::safe($log);

		// \lib\db\apilogs::insert($log);

		parent::_processor($options);
	}
}
?>