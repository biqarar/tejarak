<?php
namespace lib\utility;

class users
{

	/**
	 * THE USER DETAIL CASH
	 *
	 * @var        array
	 */
	private static $USERS_DETAIL = [];


	/**
	 * users status in database
	 *
	 * @var        array
	 */
	public static $status = ['active','awaiting','deactive','removed','filter'];


	/**
	 * get count of users whitout guest user
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function user_count()
	{
		return \lib\db\users::get_count('all');
	}


	/**
	 * Gets the tejarak total users.
	 *
	 * @return     integer  The tejarak total users.
	 */
	public static function tejarak_total_users()
	{
		$result = 0;
		$url    = root. 'public_html/files/data/';
		if(!\lib\utility\file::exists($url))
		{
			\lib\utility\file::makeDir($url, null, true);
		}
		$url .= 'total_user.txt';
		if(!\lib\utility\file::exists($url))
		{
			$result = self::user_count();
			\lib\utility\file::write($url, $result);
		}
		else
		{
			$file_time = \filemtime($url);
			if((time() - $file_time) >  (60 * 10))
			{
				$result       = self::user_count();
				\lib\utility\file::write($url, $result);
			}
			else
			{
				$result = \lib\utility\file::read($url);
			}
		}
		return $result;
	}


	/**
	 * { function_description }
	 */
	public static function signup($_args = [])
	{
		$default_args =
		[
			'mobile'      => null,
			'password'    => null,
			'permission'  => null,
			'displayname' => null,
			'ref'         => null,
			'type'        => null,
			'port'        => null,
			'user_verify' => null,
			'subport'     => null,
			'insert_id'   => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		if(!$_args['insert_id'])
		{
			return false;
		}

		$user_update = [];

		if($_args['type'] === 'inspection')
		{
			$user_update['status'] = 'deactive';
		}

		if(!empty($user_update))
		{
			\lib\db\users::update($user_update, $_args['insert_id']);
			unset(self::$USERS_DETAIL[$_args['insert_id']]);
		}

		if(isset($_args['ref']) && $_args['ref'])
		{
			\lib\db\logs::set('user:ref:signup', $_args['insert_id'], ['data' => $_args['ref'], 'meta' => func_get_args()]);
		}

		// invalid ref was set
		if(isset($_args['invalid_ref_session']))
		{
			\lib\db\logs::set('user:ref:invalid:session', $_args['insert_id'], ['data' => $_args['invalid_ref_session'], 'meta' => func_get_args()]);
		}

		if(isset($_args['invalid_ref_args']) && $_args['ref'])
		{
			\lib\db\logs::set('user:ref:invalid:args', $_args['insert_id'], ['data' => $_args['invalid_ref_args'], 'meta' => func_get_args()]);
		}
	}


	/**
	 * verify users
	 *
	 * @param      array  $_args  The arguments
	 */
	public static function verify($_args = [])
	{
		$default_args =
		[
			'mobile'   => null,
			'ref'      => null,
			'type'     => null,
			'port'     => null,
			'subport'  => null,
			'user_id'  => null,
			'language' => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		if(!$_args['user_id'])
		{
			return false;
		}

		$user_update = [];

		if(self::get_status($_args['user_id']) === 'awaiting')
		{
			$user_update['status'] = 'active';
		}

		if(!empty($user_update))
		{
			\lib\db\users::update($user_update, $_args['user_id']);
			unset(self::$USERS_DETAIL[$_args['user_id']]);
		}
	}


	/**
	 * get users method
	 *
	 * @param      <type>  $_fuck  The fuck
	 * @param      <type>  $_args  The arguments
	 */
	public static function __callStatic($_fn, $_args)
	{
		if(preg_match("/^(is|get|set)\_?(.*)$/", $_fn, $split))
		{
			if(isset($split[1]))
			{
				if(isset($_args[0]) && is_numeric($_args[0]))
				{
					if(!isset(self::$USERS_DETAIL[$_args[0]]))
					{
						self::$USERS_DETAIL[$_args[0]] = \lib\db\users::get_by_id($_args[0]);
					}
				}
				if($split[1] === 'get')
				{
					return self::static_get($split[2], ...$_args);
				}

				if($split[1] === 'set')
				{
					return self::static_set($split[2], ...$_args);
				}

				if($split[1] === 'is')
				{
					return self::static_is($split[2], ...$_args);
				}
			}
		}
	}


	/**
	 * get users data
	 *
	 * @param      <type>  $_field    The field
	 * @param      <type>  $_user_id  The user identifier
	 */
	private static function static_get($_field, $_user_id)
	{
		switch ($_field)
		{
			case 'id':
			case 'mobile':
			case 'email':
			case 'password':
			case 'displayname':
			case 'meta':
			case 'status':
			case 'parent':
			case 'permission':
			case 'datecreated':
			case 'datemodified':
			case 'username':
			case 'group':
			case 'fileid':
			case 'chatid':
			case 'setup':
			case 'name':
			case 'lastname':
			case 'father':
			case 'birthday':
			case 'shcode':
			case 'nationalcode':
			case 'shfrom':
			case 'nationality':
			case 'brithplace':
			case 'region':
			case 'pasportcode':
			case 'marital':
			case 'childcount':
			case 'education':
			case 'insurancetype':
			case 'insurancecode':
			case 'dependantscount':
			case 'postion':
			case 'unit_id':
			case 'language':
				if(isset(self::$USERS_DETAIL[$_user_id][$_field]))
				{
					return self::$USERS_DETAIL[$_user_id][$_field];
				}
				else
				{
					return null;
				}
				break;

			case 'unit':
				if(isset(self::$USERS_DETAIL[$_user_id]['unit_id']))
				{
					$unit = \lib\utility\units::get(self::$USERS_DETAIL[$_user_id]['unit_id']);
					if(isset($unit['title']))
					{
						return $unit['title'];
					}
				}
				return null;
				break;

			case null:
			default:
				if(isset(self::$USERS_DETAIL[$_user_id]))
				{
					return self::$USERS_DETAIL[$_user_id];
				}
				else
				{
					return false;
				}
				break;
		}
	}


	/**
	 * set users data
	 *
	 * @param      <type>  $_field    The field
	 * @param      <type>  $_user_id  The user identifier
	 */
	private static function static_set($_field, $_user_id, $_value = null)
	{
		$update = [];
		switch ($_field)
		{
			case 'language':
				if(\lib\utility\location\languages::check($_value))
				{
					$update['language'] = $_value;
				}
				break;

			case 'unit':
				$unit_id = \lib\utility\units::get_id($_value);
				if($unit_id)
				{
					$update['unit_id'] = $unit_id;
				}
				break;

			case 'unit_id':
				$check = \lib\utility\units::get($_value);
				if($check)
				{
					$update['unit_id'] = $_value;
				}
				break;

			case 'mobile':
			case 'email':
			case 'password':
			case 'displayname':
			case 'meta':
			case 'status':
			case 'parent':
			case 'permission':
			case 'datecreated':
			case 'datemodified':
			case 'username':
			case 'group':
			case 'fileid':
			case 'chatid':
			case 'setup':
			case 'name':
			case 'lastname':
			case 'father':
			case 'birthday':
			case 'shcode':
			case 'nationalcode':
			case 'shfrom':
			case 'nationality':
			case 'brithplace':
			case 'region':
			case 'pasportcode':
			case 'marital':
			case 'childcount':
			case 'education':
			case 'insurancetype':
			case 'insurancecode':
			case 'dependantscount':
			case 'postion':
			case 'unit_id':
			case 'language':
				$update[$_field] = $_value;
				break;
			default:
				return false;
				break;
		}
		if(!empty($update))
		{
			\lib\db\users::update($update, $_user_id);
			unset(self::$USERS_DETAIL[$_user_id]);
		}
	}


	/**
	 * check some field by some value and return true or false
	 * @example self::is_guest(user_id) = false
	 *
	 * @param      <type>   $_field    The field
	 * @param      <type>   $_user_id  The user identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	private static function static_is($_field, $_user_id)
	{
		switch ($_field)
		{
			case 'guest':
				if(isset(self::$USERS_DETAIL[$_user_id]['user_port']))
				{
					$temp = self::$USERS_DETAIL[$_user_id]['user_port'];
					$is_guest =
					[
						'guest',
						'site_guest',
						'telegram_guest',
						'api_guest',
						'android_guest',
					];

					if(in_array($temp, $is_guest))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
				break;

			case 'site':
			case 'site_guest':
			case 'telegram':
			case 'telegram_guest':
			case 'api':
			case 'api_guest':
			case 'android':
			case 'android_guest':
			case 'instagram':
			case 'google':
			case 'linkedin':
			case 'github':
			case 'facebook':
			case 'twitter':
			case 'other':
			case 'ios':
			case 'wp':
				if(isset(self::$USERS_DETAIL[$_user_id]['user_port']) && self::$USERS_DETAIL[$_user_id]['user_port'] === $_field)
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			case 'valid':
			case 'invalid':
			case 'unknown':
				if(isset(self::$USERS_DETAIL[$_user_id]['user_trust']) && self::$USERS_DETAIL[$_user_id]['user_trust'] === $_field)
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			case 'verify_mobile':
			case 'verify_complete':
			case 'verify_uniqueid':
			case 'verify_unknown':
				$field = substr($_field, 7);
				if(isset(self::$USERS_DETAIL[$_user_id]['user_verify']) && self::$USERS_DETAIL[$_user_id]['user_verify'] === $field)
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			case 'active':
			case 'awaiting':
			case 'deactive':
			case 'removed':
			case 'filter':
			case 'spam':
			case 'block':
			case 'delete':
				if(isset(self::$USERS_DETAIL[$_user_id]['status']) && self::$USERS_DETAIL[$_user_id]['status'] === $_field)
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			default:
				return null;
				break;
		}

	}
}
?>