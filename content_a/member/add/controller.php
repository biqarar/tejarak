<?php
namespace content_a\member\add;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$team_code = \lib\router::get_url(0);

		unset($_SESSION['first_go_to_setup']);

		$this->get(false, 'add')->ALL("/.*/");
		$this->post('add')->ALL("/.*/");
	}
}
?>