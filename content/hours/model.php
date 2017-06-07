<?php
namespace content\hours;
use \lib\utility;
use \lib\debug;

class model extends \content\main\model
{


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_member($_args)
	{
		$this->user_id     = $this->login('id');
		$request           = [];
		$request['team']   = isset($_args['team']) ? $_args['team'] : null;
		$request['branch'] = isset($_args['branch']) ? $_args['branch'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_member();
		return $result;
	}


	/**
	 * save hours of users
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_hours($_args)
	{

	}
}
?>