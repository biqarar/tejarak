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
		// https://tejarak.com/fa/admin/company/delete -- not inportant but doen :|
		// https://tejarak.com/fa/admin/ermile/
		// https://tejarak.com/fa/admin/ermile/edit
		// https://tejarak.com/fa/admin/ermile/branch/
		// https://tejarak.com/fa/admin/ermile/branch/add
		// https://tejarak.com/fa/admin/ermile/branch/delete -- not inportant
		// https://tejarak.com/fa/admin/ermile/sarshomar/
		// https://tejarak.com/fa/admin/ermile/sarshomar/edit
		// https://tejarak.com/fa/admin/ermile/staff/

		// https://tejarak.com/fa/admin/ermile/staff/add

		// https://tejarak.com/fa/admin/ermile/sarshomar/staff/
		// https://tejarak.com/fa/admin/ermile/getway/
		// https://tejarak.com/fa/admin/ermile/getway/add
		// https://tejarak.com/fa/admin/ermile/getway/delete
		// https://tejarak.com/fa/admin/ermile/getway/intro/edit
		// https://tejarak.com/fa/admin/ermile/staff/21387/edit
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

				default:

					break;
			}
		}

		if(isset($url[1]) && $url[1])
		{

			switch ($url[1])
			{
				case 'edit':
					$route = $this->model()->find_company($url[0]);
					if($route)
					{
						\lib\router::set_controller("content_admin\branch\controller");
						return;
					}
					break;
				case 'staff':
					$route = $this->model()->find_company($url[0]);
					if($route)
					{
						\lib\router::set_controller("content_admin\staff\controller");
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