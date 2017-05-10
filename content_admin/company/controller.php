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

		$this->get('list', 'list')->ALL("/^([^company][A-Za-z0-9]{5,})$/");
		$this->get('list', 'list')->ALL("/^company$/");

		$this->get('list', 'delete')->ALL("/^company\/delete$/");
		$this->post('delete')->ALL("/^company\/delete$/");

		$this->get()->ALL('company/add');

		$this->get('edit', 'edit')->ALL("/^([^company][A-Za-z0-9]{5,})\/edit$/");

		$this->post('edit')->ALL("/^([^company][A-Za-z0-9]{5,})\/edit$/");

		$this->post('add')->ALL('company/add');

		if(\lib\router::get_url() === 'company/add' || preg_match("/^([^company][A-Za-z0-9]{5,})\/edit$/", \lib\router::get_url()))
		{
			$this->display_name = 'content_admin\company\add_edit.html';
		}
	}
}
?>