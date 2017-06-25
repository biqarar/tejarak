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
		$this->user_id        = $this->login('id');
		$request              = [];
		$request['shortname'] = isset($_args['shortname']) ? $_args['shortname'] : null;
		$request['hours']     = true;
		// to get last hours. what i want to do?
		utility::set_request_array($request);
		$result =  $this->get_list_member();
		if($result === false)
		{
			\lib\error::access();
		}

		return $result;
	}


	/**
	 * Posts hours.
	 * save enter and exit of users
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function post_hours($_args)
	{

		if(!$this->login())
		{
			return false;
		}

		$url = (isset($_args->match->url[0])) ? $_args->match->url[0] : null;

		$this->user_id = $this->login('id');
		if(!$url)
		{
			return false;
		}

		$url = explode("/", $url);

		$request           = [];

		/**
		 * ajax to check members status
		 */
		if(utility::post('check'))
		{
			$request['shortname'] = isset($url[0]) ? $url[0] : null;
			$request['hours']     = true;

			// to get last hours. what i want to do?
			utility::set_request_array($request);
			$result = $this->get_list_member();
			debug::msg('memberList', json_encode($result, JSON_UNESCAPED_UNICODE));
			return true;
		}

		$request['team']   = isset($url[0]) ? $url[0] : null;
		$request['user']   = utility::post('user');
		$request['plus']   = utility::post('plus');
		$request['minus']  = utility::post('minus');
		$request['type']   = utility::post('type');

		utility::set_request_array($request);

		$this->add_hours();

		debug::msg('now_val', date("Y-m-d H:i:s"));
		debug::msg('now', date("H:i"));
	}
}
?>