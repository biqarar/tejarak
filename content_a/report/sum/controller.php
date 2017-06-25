<?php
namespace content_a\report\sum;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();
		$this->get()->ALL("/^([a-zA-Z0-9]+)\/report\/sum$/");

	}
}
?>