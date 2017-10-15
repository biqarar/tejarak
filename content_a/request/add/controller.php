<?php
namespace content_a\request\add;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	public function ready()
	{


		// add request to edit hour
		$this->get(false, 'add')->ALL("/.*/");
		$this->post('add')->ALL("/.*/");

	}
}
?>