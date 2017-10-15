<?php
namespace content_a\report\last;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	function ready()
	{
		parent::ready();

		$this->get(false, 'last')->ALL("/^([a-zA-Z0-9]+)\/report\/last$/");

		$this->post('last')->ALL("/^([a-zA-Z0-9]+)\/report\/last$/");
	}
}
?>