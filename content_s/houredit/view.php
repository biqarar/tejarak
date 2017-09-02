<?php
namespace content_s\houredit;
use \lib\utility;

class view extends \content_s\main\view
{
	public function config()
	{
		parent::config();

		$team_id = null;

		if($this->data->team_code)
		{
			$team_id = \lib\utility\shortURL::decode($this->data->team_code);
		}

		if($team_id)
		{
			// check admin or user of team
			$user_status = \lib\db\userteams::get(
			[
				'user_id' => $this->login('id'),
				'team_id' => $team_id,
				'limit'   => 1
			]);

			if(isset($user_status['rule']) && $user_status['rule'] === 'admin')
			{
				// this user is admin
				// set true on show_all_user
				$this->data->show_all_user = true;
				// load all user data to show
				$all_user = $this->model()->listMember($team_id);
				$this->data->all_user_list = $all_user;
			}
			else
			{
				$this->data->show_all_user = false;
				$this->data->all_user_list = [];
				// this user is user
			}
		}
	}
	/**
	 * show one request detail
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_showRequestDetail($_args)
	{
		$args                     = [];
		$hour_request_code = null;
		if(isset($_args->match->url[0][2]) && $_args->match->url[0][2])
		{
			$hour_request_code = $_args->match->url[0][2];
		}
		$args['id']                 = $hour_request_code;
		$result                     = $this->model()->request_detail($args);

		$this->data->request_detail = $result;
		$this->data->team_code      = \lib\router::get_url(0);
	}


	/**
	 * Shows the request list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_showRequestList($_args)
	{
		$args                     = [];
		$args['team']             = \lib\router::get_url(0);
		$args['user']             = utility::get('user');
		$result                   = $this->model()->request_list($args);
		$this->data->request_list = $result;
		$this->data->team_code    = \lib\router::get_url(0);
	}


	/**
	 * show time details
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_showTime($_args)
	{
		$hour_code = null;
		if(isset($_args->match->url[0][3]) && $_args->match->url[0][3])
		{
			$hour_code = $_args->match->url[0][3];
		}

		if($hour_code)
		{
			$args            = [];
			$args['id']      = $hour_code;
			$args['hour_id'] = $hour_code;
			$args['team']    = \lib\router::get_url(0);
			$myTime = $this->model()->getMyTime($args);
			$this->data->myTime = $myTime;
		}
	}
}
?>