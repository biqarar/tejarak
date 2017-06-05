<?php
namespace content_admin\team;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$this->get()->ALL('team/add');

		$this->post('add')->ALL('team/add');

		if($url === 'team/add' || preg_match("/^([^team][A-Za-z0-9]{5,})\/edit$/", $url))
		{
			$this->display_name = 'content_admin\team\add_edit.html';
		}

		$this->get('list', 'list')->ALL("/^team$/");

		$this->get('edit', 'edit')->ALL("/^([^team][A-Za-z0-9]{5,})\/edit$/");

		$this->post('edit')->ALL("/^([^team][A-Za-z0-9]{5,})\/edit$/");

		$this->get('edit', 'dashboard')->ALL("/^([^team][A-Za-z0-9]{5,})$/");

		if(preg_match("/^([^team][A-Za-z0-9]{5,})$/", $url))
		{
			$this->display_name = 'content_admin\team\dashboard.html';
		}

		// $this->get('list', 'delete')->ALL("/^team\/delete$/");

		// $this->post('delete')->ALL("/^team\/delete$/");
	}
}
?>