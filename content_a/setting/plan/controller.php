<?php
namespace content_a\setting\plan;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \lib\url::directory();

		if($url === 'setting/plan')
		{
			\lib\header::status(404);
		}
		$this->get(false, 'plan')->ALL("/.*/");
		$this->post('plan')->ALL("/.*/");

	}
}
?>