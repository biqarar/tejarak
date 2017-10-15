<?php
namespace content_a\member;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{


		unset($_SESSION['first_go_to_setup']);

		$this->get(false, 'list')->ALL("/.*/");
	}
}
?>