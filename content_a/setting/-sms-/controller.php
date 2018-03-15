<?php
namespace content_a\setting\sms;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		if(\lib\request::post())
		{
			$this->model()->sms();
		}

	}
}
?>