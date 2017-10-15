<?php
namespace content_a\member\permission;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{


		$this->get(false, 'permission')->ALL("/.*/");
		$this->post('permission')->ALL("/.*/");
	}
}
?>