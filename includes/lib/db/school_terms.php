<?php
namespace lib\db;

/** school_terms managing **/
class school_terms
{
	/**
	 * insert new schoolterm
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('school_terms', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('school_terms', ...func_get_args());
	}


	/**
	 * update the schoolterm
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('school_terms', ...func_get_args());
	}


	/**
	 * get the schoolterm
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('school_terms', ...func_get_args());
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
			'search_field' => " school_terms.title LIKE '%__string__%' "
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('school_terms', $_search, $_option);
		return $result;
	}

}
?>