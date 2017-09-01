<?php
namespace content_school\sendnotify;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'sendnotify')
		{
			\lib\error::page();
		}

		$this->get(false, "sendnotify")->ALL("/^([A-Za-z0-9]+)\/sendnotify$/");
		$this->post("sendnotify")->ALL("/^([A-Za-z0-9]+)\/sendnotify$/");
	}
}
?>