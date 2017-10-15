<?php
namespace content_a\request\hour;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	public function ready()
	{


		$url = \lib\router::get_url();

		// hour team
		$this->get(false, 'hour')->ALL("/.*/");
		$this->post('hour')->ALL("/.*/");

		unset($_SESSION['first_go_to_setup']);
	}
}
?>