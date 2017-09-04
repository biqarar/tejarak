<?php
namespace lib\db;

/** lessontimes managing **/
class lessontimes
{

	public static $public_show_field =
	"
		classtimes.*,
		lessontimes.status AS `lessontime_status`
	";

	public static $master_join =
	"
		INNER JOIN lessons ON lessons.id = lessontimes.lesson_id
		INNER JOIN classtimes ON classtimes.id = lessontimes.classtime_id

	";


	/**
	 * insert new lessontime
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('lessontimes', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('lessontimes', ...func_get_args());
	}


	/**
	 * update the lessontime
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('lessontimes', ...func_get_args());
	}


	/**
	 * get the lessontime
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('lessontimes', ...func_get_args());
	}


	/**
	 * Gets the lesson.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The lesson.
	 */
	public static function get_lessontime($_args)
	{
		$option =
		[
			'public_show_field' => self::$public_show_field,
			'master_join'       => self::$master_join,
			'table_name'        => 'lessontimes'
		];

		return self::get($_args, $option);
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
			'search_field' => " lessontimes.title LIKE '%__string__%' "
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('lessontimes', $_search, $_option);
		return $result;
	}


	public static function remove($_where)
	{
		$_where = \lib\db\config::make_where($_where);
		if($_where)
		{
			$query = " UPDATE lessontimes SET status = 'disable' WHERE $_where ";
			return \lib\db::query($query);
		}
	}

}
?>