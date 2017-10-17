<?php
namespace content_a\member\parent;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{


		$this->get(false, 'list')->ALL("/.*/");
	}
}
?>