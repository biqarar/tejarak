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

		$this->get('list', 'list')->ALL("/^([A-Za-z0-9]{5,})$/");

		$this->get()->ALL('company/add');

		$this->get('edit', 'edit')->ALL("/^([A-Za-z0-9]{5,})\/edit$/");

		$this->post('edit')->ALL("/^([A-Za-z0-9]{5,})\/edit$/");

		$this->post('add')->ALL('company/add');

		if(\lib\router::get_url() === 'company/add' || preg_match("/^([A-Za-z0-9]{5,})\/edit$/", \lib\router::get_url()))
		{
			$this->display_name = 'content_admin\company\add_edit.html';
		}
	}
}
?>