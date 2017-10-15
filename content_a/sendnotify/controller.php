<?php
namespace content_a\sendnotify;

class controller extends \content_a\main\controller
{

	public function ready()
	{


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