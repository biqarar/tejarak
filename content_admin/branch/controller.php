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

		$this->get('addbranch', 'addbranch')->ALL("/^([A-Za-z0-9]{5,})\/branch\/add$/");

		$this->post('addbranch')			->ALL("/^([A-Za-z0-9]{5,})\/branch\/add$/");

		if(
			preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/", $url) ||
			preg_match("/^([A-Za-z0-9]{5,})\/branch\/add$/", $url)
		  )
		{
			$this->display_name = 'content_admin\branch\add_edit.html';
		}

		$this->get('listbranch', 'listbranch')->ALL("/^([A-Za-z0-9]{5,})\/branch$/");

		$this->get('editbranch', 'editbranch')->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/");
		$this->post('editbranch')			  ->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/");

		$this->get('branchdashboard', 'branchdashboard')->ALL("/^([A-Za-z0-9]{5,})\/([^branch][A-Za-z0-9]{5,})$/");

		if(preg_match("/^([A-Za-z0-9]{5,})\/([^branch][A-Za-z0-9]{5,})$/", $url))
		{
			$this->display_name = 'content_admin\branch\dashboard.html';
		}

		// $this->post('branchdashboard')			        ->ALL("/^([A-Za-z0-9]{5,})\/([^branch][A-Za-z0-9]{5,})$/");

		// if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/", $url, $split))
		// {
		// 	if(isset($split[2]) && $split[2] === 'branch')
		// 	{

		// 	}
		// 	else
		// 	{
		// 		$this->display_name = 'content_admin\branch\dashboard.html';
		// 	}
		// }


		// $this->get('listbranch', 'listbranch')->ALL("/^([A-Za-z0-9]{5,})$/");

	}
}
?>