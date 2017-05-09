<?php
namespace content_admin\company;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$this->get('list', 'list')->ALL();
		$this->get()->ALL('company/add');
		$this->get('edit', 'edit')->ALL("/company\/edit\=(\d+)/");
		$this->post('edit')->ALL("/company\/edit\=(\d+)/");
		$this->post('add')->ALL('company/add');
		if(\lib\router::get_url() === 'company/add' || preg_match("/company\/edit\=(\d+)/", \lib\router::get_url()))
		{
			$this->display_name = 'content_admin\company\add.html';
		}
	}
}
?>