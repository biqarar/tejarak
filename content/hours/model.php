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
		$this->user_id        = \lib\user::id();
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

		if(!\lib\user::login())
		{
			return false;
		}

		$url = (isset($_args->match->url[0])) ? $_args->match->url[0] : null;

		$this->user_id = \lib\user::id();
		if(!$url)
		{
			return false;
		}

		$url = explode("/", $url);

		$request           = [];

		/**
		 * ajax to check members status
		 */
		if(\lib\request::post('check'))
		{
			$request['shortname'] = isset($url[0]) ? $url[0] : null;
			$request['hours']     = true;

			// to get last hours. what i want to do?
			\lib\utility::set_request_array($request);
			$result = $this->get_list_member();
			\lib\notif::msg('memberList', json_encode($result, JSON_UNESCAPED_UNICODE));
			return true;
		}

		$request['team']   = isset($url[0]) ? $url[0] : null;
		$request['user']   = \lib\request::post('user');
		$request['plus']   = \lib\request::post('plus');
		$request['minus']  = \lib\request::post('minus');
		$request['type']   = \lib\request::post('type');
		$request['desc']   = \lib\request::post('desc');

		\lib\utility::set_request_array($request);

		$this->add_hours();

		\lib\notif::msg('now_val', date("Y-m-d H:i:s"));
		\lib\notif::msg('now', date("H:i"));
	}
}
?>