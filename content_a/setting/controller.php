<?php
namespace content_a\setting;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$new_url = \lib\url::here(). '/'. \lib\url::dir(0). '/setting/general';

		\lib\redirect::to($new_url);

	}
}
?>