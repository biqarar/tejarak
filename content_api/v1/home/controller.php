<?php
namespace content_api\v1\home;

class controller extends  \addons\content_api\home\controller
{

	/**
	 * route
	 */
	public function ready()
	{
		$url = \dash\url::directory();

		switch ($url)
		{
			case 'v1/teamlist':
				\dash\engine\main::controller_set("\\content_api\\v1\\team\\controller");
				return;
				break;

			case 'v1/memberlist':
			case 'v1/membermulti':
				\dash\engine\main::controller_set("\\content_api\\v1\\member\\controller");
				return;
				break;

			case 'v1/hourslist':
				\dash\engine\main::controller_set("\\content_api\\v1\\hours\\controller");
				return;
				break;

			default:
				# code...
				break;
		}
	}
}
?>