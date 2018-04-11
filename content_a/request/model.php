<?php
namespace content_a\request;


class model
{
	/**
	 * Posts an accept reject.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post()
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


	// /**
	//  * delete request
	//  *
	//  * @param      <type>  $_args  The arguments
	//  */
	// public function delete_request($_args)
	// {
	// 	$team_id        = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
	// 	$hourrequest_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
	// 	if(!$team_id || !$hourrequest_id)
	// 	{
	// 		return false;
	// 	}

	// 	$this->user_id = \dash\user::id();
	// 	\dash\app::variable(['id' => $hourrequest_id]);
	// 	$this->hourrequest_delete(['method' => 'delete']);
	// 	\dash\redirect::to(\dash\url::here(). "/$team_id/request");
	// }


}
?>