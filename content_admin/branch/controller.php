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

		$this->get('branchdashboard', 'branchdashboard')->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/");

		if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/", $url, $split))
		{
			if(isset($split[2]) && $split[2] === 'branch')
			{

			}
			else
			{
				if(isset($split[2]))
				{
					if(!$this->check_branch_exist($split[1], $split[2]))
					{
						$this->route_check_true = false;
					}
				}
				$this->display_name = 'content_admin\branch\dashboard.html';
			}
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


	/**
	 * check the branch exist and is my branch
	 *
	 * @param      <type>   $_team  The team
	 * @param      <type>   $_branch   The branch
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	private function check_branch_exist($_team, $_branch)
	{
		$get = \lib\db\branchs::get_by_brand($_team, $_branch);
		if(isset($get['boss']) && intval($this->login('id')) === intval($get['boss']))
		{
			return true;
		}
		return false;
	}
}
?>