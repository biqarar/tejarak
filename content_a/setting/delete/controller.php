<?php
namespace content_a\setting\delete;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'setting/delete')
		{
			\dash\header::status(404);
		}
		$this->get(false, 'delete')->ALL("/.*/");
		$this->post('delete')->ALL("/.*/");

	}
}
?>