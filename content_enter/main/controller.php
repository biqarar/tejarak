<?php
namespace content_enter\main;

class controller extends \mvc\controller
{
	use \content_enter\main\tools\check_input;
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
}
?>