<?php
namespace content_s\takenunit;

class view extends \content_s\main\view
{
	/**
	 * view panel of student
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_takenunit($_args)
	{
		$id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		if($id)
		{
			$this->data->student = $this->model()->loadPanel($id);
		}

		$school_id = \lib\router::get_url(0);

		$this->data->lesson = $this->model()->loadLesson($school_id);

	}
}
?>