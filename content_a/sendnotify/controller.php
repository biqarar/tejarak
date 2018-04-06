<?php
namespace content_a\sendnotify;

class controller extends \content_a\main\controller
{

	public function ready()
	{


		$url = \dash\url::directory();

		if($url === 'sendnotify')
		{
			\dash\header::status(404);
		}

		$this->get(false, "sendnotify")->ALL("/^([A-Za-z0-9]+)\/sendnotify$/");
		$this->post("sendnotify")->ALL("/^([A-Za-z0-9]+)\/sendnotify$/");
	}
}
?>