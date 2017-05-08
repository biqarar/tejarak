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
		$this->post('add')->ALL('company/add');
		if(\lib\router::get_url() === 'company/add')
		{
			$this->display_name = 'content_admin\company\add.html';
		}
	}
}
?>