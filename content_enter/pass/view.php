<?php
namespace content_enter\pass;


class view extends \content_enter\main\view
{

	/**
	 * view enter
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function config()
	{
		$this->data->get_mobile = $this->model()->get_enter_session('mobile');
	}
}
?>