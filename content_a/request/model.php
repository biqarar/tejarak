<?php
namespace content_a\request;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{
	/**
	 * Posts an accept reject.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_hour($_args)
	{

		$response = utility::post('response');
		$id       = utility::post('id');
		$type     = utility::post('type');

		$this->user_id       = $this->login('id');
		$request             = [];
		$request['team']     = \lib\router::get_url(0);
		$request['id']       = $id;
		$request['type']     = $type;
		$request['response'] = $response;

		utility::set_request_array($request);
		$this->hourrequest_action();
	}


	/**
	 * delete request
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function delete_request($_args)
	{
		$team_id        = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$hourrequest_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		if(!$team_id || !$hourrequest_id)
		{
			return false;
		}

		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $hourrequest_id]);
		$this->hourrequest_delete(['method' => 'delete']);
		$this->redirector(\lib\url::here(). "/$team_id/request")->redirect();
	}


	// /**
	//  * show one hourrequest detail
	//  *
	//  * @param      <type>  $_request  The request
	//  *
	//  * @return     <type>  ( description_of_the_return_value )
	//  */
	// public function request_detail($_request)
	// {
	// 	$this->user_id = $this->login('id');
	// 	utility::set_request_array($_request);
	// 	return $this->get_request_detail();
	// }


	/**
	 * show request list
	 *
	 * @param      <type>  $_request  The request
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function request_list($_request)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array($_request);
		return $this->get_houredit_list();
	}


	// /**
	//  * Gets my time.
	//  * get the time record
	//  *
	//  * @param      <type>  $_args  The arguments
	//  *
	//  * @return     <type>  My time.
	//  */
	// public function getMyTime($_args)
	// {
	// 	utility::set_request_array($_args);
	// 	$this->user_id = $this->login('id');
	// 	$result = $this->get_request();

	// 	if(!$result)
	// 	{
	// 		debug::$status = 1;
	// 		$result = $this->get_hours();
	// 	}
	// 	return $result;
	// }
}
?>