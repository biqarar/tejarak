<?php
namespace lib\db;

/** school_subjects managing **/
class school_subjects
{
	/**
	 * insert new subject
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('school_subjects', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('school_subjects', ...func_get_args());
	}


	/**
	 * update the subject
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('school_subjects', ...func_get_args());
	}


	/**
	 * get the subject
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('school_subjects', ...func_get_args());
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
			'search_field' =>
			"
				(
					school_subjects.title LIKE '%__string__%' OR
					school_subjects.category LIKE '%__string__%'
				)
			"
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('school_subjects', $_search, $_option);
		return $result;
	}


	public static function get_category($_school_id)
	{
		if(!is_numeric($_school_id) || !$_school_id)
		{
			return false;
		}

		$query = "SELECT DISTINCT school_subjects.category AS `cat` FROM school_subjects WHERE school_subjects.school_id = $_school_id";
		return \lib\db::get($query, 'cat');
	}


}
?>