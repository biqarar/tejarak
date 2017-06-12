<?php
namespace content_enter\main;

class controller extends \mvc\controller
{
	use \content_enter\main\tools\done_step;
	use \content_enter\main\tools\check_input;
	use \content_enter\main\tools\user_data;
	use \content_enter\main\tools\go_to;
	use \content_enter\main\tools\SESSION;
	use \content_enter\main\tools\verification_code;
	use \content_enter\main\tools\send_code;
	use \content_enter\main\tools\error;
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