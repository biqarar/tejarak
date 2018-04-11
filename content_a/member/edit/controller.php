<?php
namespace content_a\member\edit;

class controller
{
	/**
	 * rout
	 */
	public static function routing()
	{
		$new_url = \dash\url::here(). '/member/general?id=' \dash\request::get('id'). '&member='. \dash\request::get('member');
		\dash\redirect::to($new_url);
	}
}
?>