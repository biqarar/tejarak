<?php
namespace content_enter\pass\signup;

class view extends \content_enter\main\view
{

	/**
	 * view enter
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_pass($_args)
	{
		$this->data->get_mobile = $this->model()->get_enter_session('mobile');
	}
}
?>