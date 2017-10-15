<?php
namespace content_a\report\period;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	function ready()
	{
		parent::ready();

		$this->get(false, 'period')->ALL("/^([a-zA-Z0-9]+)\/report\/period$/");
	}
}
?>