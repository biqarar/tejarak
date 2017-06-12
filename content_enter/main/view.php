<?php
namespace content_enter\main;

class view extends \mvc\view
{

	/**
	 * config
	 */
	public function config()
	{
		$this->include->css    = true;
		$this->include->js     = false;
		$this->data->bodyclass = 'unselectable';
		$this->data->bodyclass .= ' bg'. rand(1, 15);

		$this->data->get_mobile = $this->model()->get_enter_session('mobile');

	}
}
?>