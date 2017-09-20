<?php
namespace content_api\v1\home;

class controller extends  \addons\content_api\home\controller
{

	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();
		$url = \lib\router::get_url();
		switch ($url)
		{
			case 'v1/teamlist':
				\lib\router::set_controller("\\content_api\\v1\\team\\controller");
				return;
				break;

			default:
				# code...
				break;
		}
	}
}
?>