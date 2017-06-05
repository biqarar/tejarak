<?php
namespace content_admin\branch_staff;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get('liststaff', 'liststaff')				->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/staff$/");


		$this->get('addstaff', 'addstaff')					->ALL("/^([A-Za-z0-9]{5,})\/staff\/add$/");
		$this->post('addstaff')			  					->ALL("/^([A-Za-z0-9]{5,})\/staff\/add$/");

		$this->get('editstaff_company', 'editstaff_company')->ALL("/^([A-Za-z0-9]{5,})\/staff\/(\d+)\/edit$/");
		$this->post('editstaff_company')			  		->ALL("/^([A-Za-z0-9]{5,})\/staff\/(\d+)\/edit$/");

		$this->get('staffdashboard', 'staffdashboard')		->ALL("/^([A-Za-z0-9]{5,})\/([^staff][A-Za-z0-9]{5,})$/");
		$this->post('staffdashboard')			        	->ALL("/^([A-Za-z0-9]{5,})\/([^staff][A-Za-z0-9]{5,})$/");
		// var_dump($this);exit();
		if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/", \lib\router::get_url(), $split))
		{
			if(isset($split[2]) && $split[2] === 'staff')
			{

			}
			else
			{
				$this->display_name = 'content_admin\branch_staff\dashboard.html';
			}
		}

		if(
			preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/", \lib\router::get_url()) ||
			preg_match("/^([A-Za-z0-9]{5,})\/staff\/add$/", \lib\router::get_url()) ||
			preg_match("/^([A-Za-z0-9]{5,})\/staff\/(\d+)\/edit$/", \lib\router::get_url()))
		{
			$this->display_name = 'content_admin\branch_staff\add.html';
		}

		$this->get('liststaff', 'liststaff')						->ALL("/^([A-Za-z0-9]{5,})$/");
		$this->get('liststaff', 'liststaff')						->ALL("/^([A-Za-z0-9]{5,})\/staff$/");

	}
}
?>