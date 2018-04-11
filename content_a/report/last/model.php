<?php
namespace content_a\report\last;


class model
{

	/**
	 * Posts a last.
	 */
	public function post()
	{
		$request            = [];
		$request['hour_id'] = \dash\request::post('hour_id');
		$request['type']    = \dash\request::post('type');
		return \lib\app\horedit::hour_change_type();
	}
}
?>