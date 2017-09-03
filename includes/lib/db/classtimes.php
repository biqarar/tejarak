<?php
namespace lib\db;

/** classtimes managing **/
class classtimes
{
	/**
	 * insert new classtime
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('classtimes', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('classtimes', ...func_get_args());
	}


	/**
	 * update the classtime
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('classtimes', ...func_get_args());
	}


	/**
	 * get the classtime
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('classtimes', ...func_get_args());
	}


	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search($_search = null, $_option = [])
	{
		if(!is_array($_option))
		{
			$_option = [];
		}
		$default_option =
		[
			'search_field' => " classtimes.title LIKE '%__string__%' "
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('classtimes', $_search, $_option);
		return $result;
	}

}
?>