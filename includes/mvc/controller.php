<?php
namespace mvc;

class controller extends \lib\mvc\controller
{

	/**
	 * { function_description }
	 */
	public function _route()
	{
		// check if have cookie set login by remember
		if(!$this->login())
		{
			\content_enter\main\tools\login::login_by_remember();
		}
	}

}
?>