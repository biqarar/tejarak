<?php
namespace content_a\request;


class model
{
	/**
	 * Posts an accept reject.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{

		$response = \dash\request::post('response');
		$id       = \dash\request::post('id');
		$type     = \dash\request::post('type');

		$request             = [];
		$request['team']     = \dash\request::get('id');
		$request['id']       = $id;
		$request['type']     = $type;
		$request['response'] = $response;

		\dash\app::variable($request);
		\lib\app\houredit::hourrequest_action();
	}
}
?>