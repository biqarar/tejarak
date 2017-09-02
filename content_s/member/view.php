<?php
namespace content_s\member;

class view extends \content_s\main\view
{
	/**
	 * teacher or student
	 *
	 * @var        <type>
	 */
	public $type = null;

	use teacher\view_teacher;
	use student\view_student;


}
?>