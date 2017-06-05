<?php
namespace content_admin\branch;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		// the add page similar team/ermile/branch
		// this page add a branch of ermile
		$add_reg = "/^team\/([a-zA-Z0-9]+)\/branch$/";

		$this->get(false, 'add')->ALL($add_reg);
		$this->post('add')->ALL($add_reg);

		if(preg_match($add_reg, $url))
		{
			$this->display_name = 'content_admin\branch\add_edit.html';
		}
	}
}
?>