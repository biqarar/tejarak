<?php
namespace lib\db;

/** units managing **/
class units
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_id    The identifier
	 */
	public static function get($_id = null, $_get_title = false)
	{
		$id = null;
		if($_id)
		{
			$id = " WHERE id = $_id ";
		}
		$query = "SELECT * FROM units $id";
		if($id)
		{
			$result = \lib\db::get($query, null, true);
		}
		else
		{
			$result = \lib\db::get($query);
		}

		if($_get_title)
		{
			if(isset($result['title']))
			{
				return $result['title'];
			}
			elseif(isset($result[0]['title']))
			{
				return array_column($result, 'title');
			}
		}
		return $result;
	}

	/**
	 * Gets the unit identifier.
	 *
	 * @param      <type>   $_unit_title  The unit title
	 *
	 * @return     boolean  The identifier.
	 */
	public static function get_id($_unit_title)
	{
		$query = "SELECT id FROM units WHERE units.title = '$_unit_title' LIMIT 1";
		$result = \lib\db::get($query, 'id', true);
		if(!$result || empty($result) || is_array($result))
		{
			return false;
		}
		return $result;
	}


	/**
	 * get the user unit
	 *
	 * @param      <type>  $_caller  The caller
	 */
	public static function user_unit($_user_id)
	{
		$user_unit = \lib\utility\users::get_unit($_user_id);
		if($user_unit)
		{
			return $user_unit;
		}
		return false;
	}


	/**
	 * Sets the user unit.
	 *
	 * @param      <type>  $_user_id  The user identifier
	 * @param      <type>  $_unit     The unit
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function set_user_unit($_user_id, $_unit)
	{
		if(!$_unit)
		{
			return false;
		}

		\lib\utility\users::set_unit($_user_id, $_unit);
		return true;
	}


	/**
	 * find user unit
	 *
	 * @param      <type>  $_user_id  The user identifier
	 */
	public static function find_user_unit($_user_id, $_set_user_unit_if_find = false)
	{
		// get curretn unit
		$isset_unit = self::user_unit($_user_id);
		if($isset_unit)
		{
			return $isset_unit;
		}

		if($_set_user_unit_if_find)
		{
			self::set_user_unit($_user_id, 'toman');
		}
		return 'toman';
	}



	/**
	 * insert new record of units
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert($_args)
	{
		$default_args =
		[
			'title' => null,
			'desc'  => null,
			'meta'  => null,
		];
		$_args = array_merge($default_args, $_args);

		$set = [];
		foreach ($_args as $field => $value)
		{
			if($value === null)
			{
				$set[] = " units.$field = NULL ";
			}
			elseif(is_numeric($value))
			{
				$set[] = " units.$field = $value ";
			}
			elseif(is_string($value))
			{
				$set[] = " units.$field = '$value' ";
			}
		}
		$set = implode(",", $set);

		$query =
		"
			INSERT INTO
				units
			SET
				$set
		";
		$result = \lib\db::query($query);
		return $result;
	}
/**
	 * update record of units
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update($_args, $_id)
	{
		$default_args =
		[
			'title' => null,
			'desc'  => null,
			'meta'  => null,
		];
		$_args = array_merge($default_args, $_args);

		$set = [];
		foreach ($_args as $field => $value)
		{
			if($value === null)
			{
				$set[] = " units.$field = NULL ";
			}
			elseif(is_numeric($value))
			{
				$set[] = " units.$field = $value ";
			}
			elseif(is_string($value))
			{
				$set[] = " units.$field = '$value' ";
			}
		}
		$set = implode(",", $set);

		$query =
		"
			UPDATE
				units
			SET
				$set
			WHERE
				units.id = $_id
		";

		$result = \lib\db::query($query);
		return $result;
	}

}
?>