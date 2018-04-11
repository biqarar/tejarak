<?php
namespace content_a\setting;

class controller
{
	/**
	 * rout
	 */
	public static function routing()
	{
		$new_url = \dash\url::here(). '/setting/general?id='. \dash\request::get('id');

		\dash\redirect::to($new_url);

	}
}
?>