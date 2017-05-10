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

		$this->get('addbranch', 'addbranch')->ALL("/^([A-Za-z0-9]{5,})\/branch\/add$/");
		$this->post('addbranch')			->ALL("/^([A-Za-z0-9]{5,})\/branch\/add$/");

		$this->get('editbranch', 'editbranch')->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/");
		$this->post('editbranch')			  ->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/");

		$this->get('branchdashboard', 'branchdashboard')->ALL("/^([A-Za-z0-9]{5,})\/([^branch][A-Za-z0-9]{5,})$/");
		$this->post('branchdashboard')			        ->ALL("/^([A-Za-z0-9]{5,})\/([^branch][A-Za-z0-9]{5,})$/");

		if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/", \lib\router::get_url(), $split))
		{
			if(isset($split[2]) && $split[2] === 'branch')
			{

			}
			else
			{
				$this->display_name = 'content_admin\branch\dashboard.html';
			}
		}

		if(
			preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/", \lib\router::get_url()) ||
			preg_match("/^([A-Za-z0-9]{5,})\/branch\/add$/", \lib\router::get_url())
		  )
		{
			$this->display_name = 'content_admin\branch\add.html';
		}

		$this->get('listbranch', 'listbranch')->ALL("/^([A-Za-z0-9]{5,})$/");
		$this->get('listbranch', 'listbranch')->ALL("/^([A-Za-z0-9]{5,})\/branch$/");

	}
}
?>