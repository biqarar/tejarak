<?php
namespace lib\db;

/** schoolterms managing **/
class schoolterms
{
	/**
	 * insert new schoolterm
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('schoolterms', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('schoolterms', ...func_get_args());
	}


	/**
	 * update the schoolterm
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('schoolterms', ...func_get_args());
	}


	/**
	 * get the schoolterm
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('schoolterms', ...func_get_args());
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
			'search_field' => " schoolterms.title LIKE '%__string__%' "
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('schoolterms', $_search, $_option);
		return $result;
	}

}
?>