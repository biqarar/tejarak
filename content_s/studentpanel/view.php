<?php
namespace content_s\studentpanel;

class view extends \content_s\main\view
{
	/**
	 * view panel of student
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_panel($_args)
	{
		$id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		if($id)
		{
			$this->data->student = $this->model()->loadPanel($id);
		}
	}
}
?>