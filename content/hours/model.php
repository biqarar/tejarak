<?php
namespace content\hours;
use \lib\utility;
use \lib\debug;

class model extends \content\main\model
{

	use \content_api\v1\hours\tools\add;

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

		if(!$url)
		{
			return false;
		}

		$url = explode("/", $url);

		$request           = [];
		$request['team']   = isset($url[0]) ? $url[0] : null;
		$request['branch'] = isset($url[1]) ? $url[1] : null;
		$request['user']   = utility::post('user');
		$request['plus']   = utility::post('plus');
		$request['minus']  = utility::post('minus');
		$request['type']   = utility::post('type');

		$this->user_id = $this->login('id');

		utility::set_request_array($request);

		$this->add_hours();
	}
}
?>