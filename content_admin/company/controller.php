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

		$url = \lib\router::get_url();

		$this->get()->ALL('company/add');

		$this->post('add')->ALL('company/add');

		if($url === 'company/add' || preg_match("/^([^company][A-Za-z0-9]{5,})\/edit$/", $url))
		{
			$this->display_name = 'content_admin\company\add_edit.html';
		}

		$this->get('list', 'list')->ALL("/^company$/");

		$this->get('edit', 'edit')->ALL("/^([^company][A-Za-z0-9]{5,})\/edit$/");

		$this->post('edit')->ALL("/^([^company][A-Za-z0-9]{5,})\/edit$/");

		$this->get('edit', 'dashboard')->ALL("/^([^company][A-Za-z0-9]{5,})$/");

		if(preg_match("/^([^company][A-Za-z0-9]{5,})$/", $url))
		{
			$this->display_name = 'content_admin\company\dashboard.html';
		}

		// $this->get('list', 'delete')->ALL("/^company\/delete$/");

		// $this->post('delete')->ALL("/^company\/delete$/");
	}
}
?>