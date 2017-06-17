<?php
namespace content_a\branch_member;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get('listmember', 'listmember')				->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/member$/");


		$this->get('addmember', 'addmember')					->ALL("/^([A-Za-z0-9]{5,})\/member\/add$/");
		$this->post('addmember')			  					->ALL("/^([A-Za-z0-9]{5,})\/member\/add$/");

		$this->get('editmember_team', 'editmember_team')->ALL("/^([A-Za-z0-9]{5,})\/member\/(\d+)\/edit$/");
		$this->post('editmember_team')			  		->ALL("/^([A-Za-z0-9]{5,})\/member\/(\d+)\/edit$/");

		$this->get('memberdashboard', 'memberdashboard')		->ALL("/^([A-Za-z0-9]{5,})\/([^member][A-Za-z0-9]{5,})$/");
		$this->post('memberdashboard')			        	->ALL("/^([A-Za-z0-9]{5,})\/([^member][A-Za-z0-9]{5,})$/");
		// var_dump($this);exit();
		if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/", \lib\router::get_url(), $split))
		{
			if(isset($split[2]) && $split[2] === 'member')
			{

			}
			else
			{
				$this->display_name = 'content_a\branch_member\dashboard.html';
			}
		}

		if(
			preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/", \lib\router::get_url()) ||
			preg_match("/^([A-Za-z0-9]{5,})\/member\/add$/", \lib\router::get_url()) ||
			preg_match("/^([A-Za-z0-9]{5,})\/member\/(\d+)\/edit$/", \lib\router::get_url()))
		{
			$this->display_name = 'content_a\branch_member\add.html';
		}

		$this->get('listmember', 'listmember')						->ALL("/^([A-Za-z0-9]{5,})$/");
		$this->get('listmember', 'listmember')						->ALL("/^([A-Za-z0-9]{5,})\/member$/");

	}
}
?>