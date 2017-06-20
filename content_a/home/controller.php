<?php
namespace content_a\home;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();


		// if user_setup is null redirect to setup page
		if(!$this->login('setup'))
		{
			$this->redirector()->set_domain()->set_url('a/setup')->redirect();
			return;
		}

		$this->get(false, 'dashboard')->ALL();

		// route url like this /a/ermile
		if(preg_match("/^[a-zA-Z0-9]+$/", $url))
		{
			if($this->model()->is_exist_team($url))
			{
				\lib\router::set_controller("content_a\\branch\\controller");
				return;
			}
		}

		// route url like this /a/ermile/sarshomar
		if(preg_match("/^([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)$/", $url, $split))
		{
			if(isset($split[1]) && isset($split[2]))
			{
				if($this->model()->is_exist_team($split[1]))
				{
					if(\lib\db\branchs::get_by_brand($split[1], $split[2]))
					{
						\lib\router::set_controller("content_a\\member\\controller");
						return;
					}
				}
			}
		}


		/**
		 * route report urls
		 * in url must be find .../report/... | .../report
		 */
		if(preg_match("/(\/report\/)|(\/report$)/", $url))
		{
			\lib\router::set_controller("content_a\\report\\controller");
			return;
		}
	}
}
?>