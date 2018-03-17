<?php
namespace content_a\member;


class model extends \content_a\main\model
{

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_member($_args)
	{
		$this->user_id = \lib\user::id();
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		\lib\utility::set_request_array($request);
		$result =  $this->get_list_member();
		return $result;
	}


	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team, $_member)
	{
		$this->user_id    = \lib\user::id();
		$request          = [];
		$request['team']  = $_team;
		$request['id']    = $_member;
		\lib\utility::set_request_array($request);
		$result           =  $this->get_member();
		return $result;
	}

}
?>