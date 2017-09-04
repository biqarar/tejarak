<?php
namespace lib\db;

/** school_userlessons managing **/
class school_userlessons
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
		INNER JOIN school_terms ON school_terms.id = school_userlessons.schoolterm_id
		INNER JOIN school_lessons ON school_lessons.id = school_userlessons.lesson_id
		INNER JOIN teams ON teams.id = school_userlessons.classroom
		INNER JOIN userteams ON userteams.id = school_userlessons.teacher
		INNER JOIN school_subjects ON school_subjects.id = school_userlessons.subject_id
	";


	/**
	 * insert new subject
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return \lib\db\config::public_insert('school_userlessons', ...func_get_args());
	}


	/**
	 * make multi insert
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('school_userlessons', ...func_get_args());
	}


	/**
	 * update the subject
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('school_userlessons', ...func_get_args());
	}


	/**
	 * get the subject
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('school_userlessons', ...func_get_args());
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
		$result = \lib\db\config::public_search('school_userlessons', $_search, $_option);
		return $result;
	}

}
?>