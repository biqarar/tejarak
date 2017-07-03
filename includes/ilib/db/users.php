<?php
namespace ilib\db;

/** users account managing **/
class users extends \lib\db\users
{
	/**
	 * this library work with acoount
	 * v1.2
	 */


	/**
	 * get all data by email
	 *
	 * @param      <type>  $_email  The email
	 *
	 * @return     <type>  The identifier.
	 */
	public static function get_by_email($_email, $_field = false)
	{
		switch ($_field)
		{
			case 'all':
				$query =
				"
					SELECT * FROM users
					WHERE
					(
						users.user_email         = '$_email' OR
						users.user_google_mail   = '$_email' OR
						users.user_facebook_mail = '$_email' OR
						users.user_twitter_mail  = '$_email'
					) AND
					users.user_status != 'removed'
					ORDER BY users.id DESC
					LIMIT 1
				";
				break;

			case 'user_google_mail':
			case 'user_facebook_mail':
			case 'user_twitter_mail':
				$query =
				"
					SELECT *
					FROM users
					WHERE users.$_field = '$_email'
					AND users.user_status != 'removed'
					ORDER BY users.id DESC
					LIMIT 1
				";
				break;

			case false:
			case 'user_email':
			default:
				$query =
				"
					SELECT *
					FROM users
					WHERE users.user_email = '$_email'
					AND users.user_status != 'removed'
					ORDER BY users.id DESC
					LIMIT 1
				";
				break;
		}

		return \lib\db::get($query, null, true);
	}


	/**
	 * get all data by username
	 *
	 * @param      <type>  $_username  The username
	 *
	 * @return     <type>  The identifier.
	 */
	public static function get_by_username($_username)
	{
		$query =
		"
			SELECT *
			FROM users
			WHERE users.user_username = '$_username'
			AND users.user_status != 'removed'
			ORDER BY users.id DESC
			LIMIT 1
			-- users::get_by_username()
		";
		return \lib\db::get($query, null, true);
	}


	/**
	 * get all data by mobile
	 *
	 * @param      <type>  $_mobile  The mobile
	 *
	 * @return     <type>  The identifier.
	 */
	public static function get_by_mobile($_mobile)
	{
		$query =
		"
			SELECT *
			FROM users
			WHERE users.user_mobile = '$_mobile'
			AND users.user_status != 'removed'
			ORDER BY users.id DESC
			LIMIT 1
			-- users::get_id()
		";
		return \lib\db::get($query, null, true);
	}


	/**
	 * insert new recrod in users table
	 * @param array $_args fields data
	 * @return mysql result
	 */
	public static function insert($_args)
	{
		return \lib\db\config::public_insert('users', $_args);
	}


	/**
	 * insert multi record in one query
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function insert_multi($_args)
	{
		if(!is_array($_args))
		{
			return false;
		}
		// marge all input array to creat list of field to be insert
		$fields = [];
		foreach ($_args as $key => $value)
		{
			$fields = array_merge($fields, $value);
		}
		// empty record not inserted
		if(empty($fields))
		{
			return true;
		}

		// creat multi insert query : INSERT INTO TABLE (FIELDS) VLUES (values), (values), ...
		$values = [];
		$together = [];
		foreach ($_args	 as $key => $value)
		{
			foreach ($fields as $field_name => $vain)
			{
				if(array_key_exists($field_name, $value))
				{
					$values[] = "'" . $value[$field_name] . "'";
				}
				else
				{
					$values[] = "NULL";
				}
			}
			$together[] = join($values, ",");
			$values     = [];
		}

		$fields = join(array_keys($fields), ",");

		$values = join($together, "),(");

		// crate string query
		$query = "INSERT INTO users ($fields) VALUES ($values) ";

		\lib\db::query($query);
		return \lib\db::insert_id();
	}


	/**
	 * update users
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update($_args, $_id)
	{
		return \lib\db\config::public_update('users', ...func_get_args());
	}


	/**
	 * check valid ref
	 *
	 * @param      <type>  $_ref   The reference
	 */
	private static function check_ref($_ref)
	{
		if(!is_string($_ref))
		{
			return null;
		}

		if($_ref)
		{
			$ref_id = \lib\utility\shortURL::decode($_ref);
			if($ref_id)
			{
				$check_ref = self::get($ref_id);
				if(!empty($check_ref))
				{
					return $ref_id;
				}
			}
		}
		return null;
	}


	/**
	 * check signup and if can add new user
	 * @return [type] [description]
	 */
	public static function signup($_args = [])
	{
		$default_args =
		[
			'user_mobile'      => null,
			'user_pass'    => null,
			'user_email'       => null,
			'user_permission'  => null,
			'user_displayname' => null,
			'user_ref'         => null,
			'type'             => null,
		];
		$temp = [];
		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		if($_args['type'] === 'inspection')
		{
			$_args['user_displayname'] = "Guest Session";
			if(!$_args['user_mobile'])
			{
				$_args['user_mobile'] = \lib\utility\filter::temp_mobile();
			}
			$_args['user_pass'] = null;
		}
		unset($_args['type']);

		// first if perm is true get default permission from db
		if($_args['user_permission'] === true)
		{
			// if use true fill it with default value
			$_args['user_permission']     = \lib\option::config('default_permission');
			// default value not set in database
			if($_args['user_permission'] == '')
			{
				$_args['user_permission'] = null;
			}
		}
		else
		{
			$_args['user_permission'] = null;
		}

		if(self::get_by_mobile($_args['user_mobile']))
		{
			// signup called and the mobile exist
			return false;
		}
		else
		{
			$ref = null;
			// get the ref and set in users_parent
			if(isset($_SESSION['ref']))
			{
				$ref = self::check_ref($_SESSION['ref']);
				if(!$ref)
				{
					$temp['invalid_ref_session'] = $_SESSION['ref'];
				}
			}
			elseif($_args['user_ref'])
			{
				$ref = self::check_ref($_args['user_ref']);
				if(!$ref)
				{
					$temp['invalid_ref_args'] = $_args['user_ref'];
				}
			}
			// elseif(\lib\utility::cookie('ref'))
			// {
			// 	$ref = self::check_ref(\lib\utility::cookie('ref'));
			// }

			if($ref)
			{
				unset($_SESSION['ref']);
				$_args['user_ref'] = $ref;
			}

			$_args['user_displayname'] = \lib\utility\safe::safe($_args['user_displayname']);

			if(mb_strlen($_args['user_displayname']) > 99)
			{
				$_args['user_displayname'] = null;
			}

			// check email exist
			if($_args['user_email'])
			{
				if(self::get_by_email($_args['user_email']))
				{
					// the user by this email exist
					return false;
				}
			}

			$_args['user_createdate'] = date('Y-m-d H:i:s');

			$insert_new    = self::insert($_args);
			$insert_id     = \lib\db::insert_id();
			self::$user_id = $insert_id;

			if(method_exists('\lib\utility\users', 'signup'))
			{
				$_args['insert_id'] = $insert_id;
				if(isset($temp['invalid_ref_session']))
				{
					$_args['invalid_ref_session'] = $temp['invalid_ref_session'];
				}
				if(isset($temp['invalid_ref_args']))
				{
					$_args['invalid_ref_args'] = $temp['invalid_ref_args'];
				}

				\lib\utility\users::signup($_args);
			}
			return $insert_id;
		}
	}


	/**
	 * get users data
	 *
	 * @param      <type>  $_user_id  The user identifier
	 * @param      <type>  $_field    The field
	 *
	 * @return     <type>  The user data.
	 */
	public static function get_user_data($_user_id, $_field = null)
	{
		if($_field == null)
		{
			$_field = "*";
		}
		elseif(is_array($_field))
		{
			$field = [];
			foreach ($_field as $key => $value)
			{
				$field[] = " users.$value ";
			}
			$_field = join($field, ",");
		}
		elseif(is_string($_field))
		{
			$_field = " users.$_field AS '$_field' ";
		}
		else
		{
			return false;
		}
		$query =
		"
			SELECT
				$_field
			FROM
				users
			WHERE
				users.id = $_user_id
			LIMIT 1
		";
		$result = \lib\db::get($query, null, true);
		return $result;
	}


	/**
	 * Sets the user data.
	 *
	 * @param      <type>  $_user_id  The user identifier
	 * @param      <type>  $_field    The field
	 * @param      <type>  $_value    The value
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function set_user_data($_user_id, $_field, $_value)
	{
		$query =
		"
			UPDATE
				users
			SET
				users.$_field = '$_value'
			WHERE
				users.id = $_user_id
		";
		$result = \lib\db::query($query);
		return $result;
	}


	/**
	 * set login session
	 *
	 * @param      <type>  $_user_id  The user identifier
	 */
	public static function set_login_session($_datarow = null, $_fields = null, $_user_id = null)
	{
		// if user id set load user data by get from database
		if($_user_id)
		{
			// load all user field
			$user_data = self::get_user_data($_user_id);

			// check the reault is true
			if(is_array($user_data))
			{
				$_datarow = $user_data;
			}
			else
			{
				return false;
			}
		}

		// set main cat of session
		$_SESSION['user']       = [];
		$_SESSION['permission'] = [];

		if(is_array($_datarow))
		{
			// and set the session
			foreach ($_datarow as $key => $value)
			{
				if(substr($key, 0, 5) === 'user_')
				{
					// remove 'user_' from first of index of session
					$key = substr($key, 5);
					if($key == 'meta' && is_string($value))
					{
						$_SESSION['user'][$key] = json_decode($value, true);
					}
					else
					{
						$_SESSION['user'][$key] = $value;
					}
				}
				else
				{
					$_SESSION['user'][$key] = $value;
				}
			}
		}
	}
}
?>