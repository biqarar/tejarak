<?php
namespace content_a\member\identify;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{


		$this->get(false, 'identify')->ALL("/.*/");
		$this->post('identify')->ALL("/.*/");
	}
}
?>