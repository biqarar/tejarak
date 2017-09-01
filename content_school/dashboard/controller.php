<?php
namespace content_school\dashboard;

class controller extends \content_school\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();


		$url = \lib\router::get_url();

		// add school
		$this->get(false, 'add')->ALL("/([a-zA_Z0-9]+)/");

	}
}
?>