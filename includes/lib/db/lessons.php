<?php
namespace lib\db;

/** lessons managing **/
class lessons
{
	public static $public_show_field =
	"
		lessons.*,
		lessons.id AS `lesson_id`,

		schoolterms.start AS `schoolterm_start`,
		schoolterms.end   AS `schoolterm_end`,
		schoolterms.title AS `schoolterm_title`,

		teams.name    AS `classroom`,

		userteams.firstname AS `teacher_name`,
		userteams.lastname  AS `teacher_family`,

		subjects.title  AS `subject_title`
	";

	public static $master_join =
	"
		INNER JOIN schoolterms ON schoolterms.id = lessons.schoolterm_id
		INNER JOIN teams ON teams.id = lessons.place_id
		INNER JOIN userteams ON userteams.id = lessons.teacher
		INNER JOIN subjects ON subjects.id = lessons.subject_id
	";

	/**
	 * insert new lesson
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('lessons', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('lessons', ...func_get_args());
	}


	/**
	 * update the lesson
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('lessons', ...func_get_args());
	}


	/**
	 * get the lesson
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('lessons', ...func_get_args());
	}


	/**
	 * Gets the lesson.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The lesson.
	 */
	public static function get_lesson($_args)
	{
		return self::get($_args, ['public_show_field' => self::$public_show_field, 'master_join' => self::$master_join, 'table_name' => 'lessons']);
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
			'public_show_field' => self::$public_show_field,

			'search_field' =>
			"
				(
					subjects.title LIKE '%__string__%'  OR
					userteams.lastname LIKE '%__string__%'

				)
			",

			'master_join' => self::$master_join,
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('lessons', $_search, $_option);
		return $result;
	}

}
?>