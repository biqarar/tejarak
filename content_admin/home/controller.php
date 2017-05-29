<?php
namespace content_admin\home;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$url = explode('/', $url);

		// https://tejarak.com/fa/admin/
		// https://tejarak.com/fa/admin/company
		// https://tejarak.com/fa/admin/company/add
		// https://tejarak.com/fa/admin/company/delete -- not important but done :|

		// https://tejarak.com/fa/admin/ermile/
		// https://tejarak.com/fa/admin/ermile/edit

		// https://tejarak.com/fa/admin/ermile/branch/
		// https://tejarak.com/fa/admin/ermile/branch/add
		// https://tejarak.com/fa/admin/ermile/branch/delete -- not important

		// https://tejarak.com/fa/admin/ermile/sarshomar/
		// https://tejarak.com/fa/admin/ermile/sarshomar/edit

		// https://tejarak.com/fa/admin/ermile/staff/
		// https://tejarak.com/fa/admin/ermile/staff/add
		// https://tejarak.com/fa/admin/ermile/staff/21387/edit -- when have code
		// https://tejarak.com/fa/admin/ermile/staff/2Kfg/edit -- when have not code
		// https://tejarak.com/fa/admin/ermile/staff/21387 -- when have code
		// https://tejarak.com/fa/admin/ermile/staff/2Kfg -- when have not code

		// https://tejarak.com/fa/admin/ermile/sarshomar/staff/

		// https://tejarak.com/fa/admin/ermile/sarshomar/getway
		// https://tejarak.com/fa/admin/ermile/sarshomar/getway/add
		// https://tejarak.com/fa/admin/ermile/sarshomar/getway/1/edit
		// https://tejarak.com/fa/admin/ermile/sarshomar/getway/1/delete

		// https://tejarak.com/fa/admin/ermile/getway/  -- ???
		// https://tejarak.com/fa/admin/ermile/getway/add
		// https://tejarak.com/fa/admin/ermile/getway/delete
		// https://tejarak.com/fa/admin/ermile/getway/intro/edit

		// https://tejarak.com/fa/admin/ermile/sarshomar/report/

		// var_dump($url);exit();

		if(isset($url[2]) && $url[2])
		{
			// for example 'staff'
			switch ($url[2])
			{
				case 'edit':
					$route = $this->model()->find_company($url[0]);

					if($route)
					{
						\lib\router::set_controller("content_admin\branch\controller");
						return;
					}
					break;

				case 'getway':
					$route = $this->model()->find_company($url[0]);
					if($route)
					{
						\lib\router::set_controller("content_admin\getway\controller");
						return;
					}
					break;

				case 'staff':
					$route = $this->model()->find_company($url[0]);

					if($route)
					{
						\lib\router::set_controller("content_admin\branch_staff\controller");
						return;
					}
					break;

				default:

					break;
			}
		}


		if(isset($url[1]) && $url[1])
		{

			if($url[1] === 'staff')
			{
				$route = $this->model()->find_company($url[0]);
				if($route)
				{
					\lib\router::set_controller("content_admin\staff\controller");
					return;
				}
			}


			$go_to_company =
			[
				'edit',
			];

			if(!in_array($url[1], $go_to_company))
			{
				$route = $this->model()->find_company($url[0]);

				if($route)
				{
					\lib\router::set_controller("content_admin\branch\controller");
					return;
				}
			}
		}

		if(isset($url[0]) && $url[0])
		{
			// for example 'ermile'
			$route = $this->model()->find_company($url[0]);

			if($route)
			{
				\lib\router::set_controller("content_admin\company\controller");
				return;
			}
		}
	}
}
?>