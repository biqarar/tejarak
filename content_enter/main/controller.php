<?php
namespace content_enter\main;

class controller extends \mvc\controller
{
	use _use;
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		$url = \lib\router::get_url();
		// /main can not route
		if($url === 'main')
		{
			\lib\error::page(T_("Unavalible"));
		}
	}


	/**
	* if the user is login redirect to base
	*/
	public function if_login_not_route()
	{
		if($this->login())
		{
			self::go_to($this->url('base'));
		}
	}
}
?>