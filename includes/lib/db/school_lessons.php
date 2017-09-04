<?php
namespace lib\db;

/** school_lessons managing **/
class school_lessons
{
	public static $public_show_field =
	"
		school_lessons.*,
		school_lessons.id AS `lesson_id`,

		school_terms.start AS `schoolterm_start`,
		school_terms.end   AS `schoolterm_end`,
		school_terms.title AS `schoolterm_title`,

		teams.id    AS `classroom_id`,
		teams.name    AS `classroom_name`,

		userteams.firstname AS `teacher_name`,
		userteams.lastname  AS `teacher_family`,

		school_subjects.title  AS `subject_title`
	";

	public static $master_join =
	"
		INNER JOIN school_terms ON school_terms.id = school_lessons.schoolterm_id
		INNER JOIN teams ON teams.id = school_lessons.classroom
		INNER JOIN userteams ON userteams.id = school_lessons.teacher
		INNER JOIN school_subjects ON school_subjects.id = school_lessons.subject_id
	";

	/**
	 * insert new lesson
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('school_lessons', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('school_lessons', ...func_get_args());
	}


	/**
	 * update the lesson
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('school_lessons', ...func_get_args());
	}


	/**
	 * get the lesson
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('school_lessons', ...func_get_args());
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
		$result = self::get($_args, ['public_show_field' => self::$public_show_field, 'master_join' => self::$master_join, 'table_name' => 'school_lessons']);
		return $result;
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
					school_subjects.title LIKE '%__string__%'  OR
					userteams.lastname LIKE '%__string__%'

				)
			",

			'master_join' => self::$master_join,
		];
		$_option = array_merge($default_option, $_option);
		$result = \lib\db\config::public_search('school_lessons', $_search, $_option);
		return $result;
	}

}
?>