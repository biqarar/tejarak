<?php
namespace content\hours;


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
		\lib\utility::set_request_array($request);
		$result =  $this->get_list_member();

		// if($result === false)
		// {
		// 	\lib\error::access(T_("Can not access to show this team"));
		// }

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
		if(\lib\utility::post('check'))
		{
			$request['shortname'] = isset($url[0]) ? $url[0] : null;
			$request['hours']     = true;

			// to get last hours. what i want to do?
			\lib\utility::set_request_array($request);
			$result = $this->get_list_member();
			\lib\debug::msg('memberList', json_encode($result, JSON_UNESCAPED_UNICODE));
			return true;
		}

		$request['team']   = isset($url[0]) ? $url[0] : null;
		$request['user']   = \lib\utility::post('user');
		$request['plus']   = \lib\utility::post('plus');
		$request['minus']  = \lib\utility::post('minus');
		$request['type']   = \lib\utility::post('type');
		$request['desc']   = \lib\utility::post('desc');

		\lib\utility::set_request_array($request);

		$this->add_hours();

		\lib\debug::msg('now_val', date("Y-m-d H:i:s"));
		\lib\debug::msg('now', date("H:i"));
	}
}
?>