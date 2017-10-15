<?php
namespace content_a\report\month;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	function ready()
	{
		parent::ready();

		$this->get(false, 'month')->ALL("/^([a-zA-Z0-9]+)\/report\/month$/");
	}
}
?>