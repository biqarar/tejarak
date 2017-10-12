<?php
namespace content_a\request;
use \lib\utility;

class view extends \content_a\main\view
{
	public function config()
	{
		parent::config();

		$load_user_in_team = \lib\temp::get('userteam_login_detail');
		if(isset($load_user_in_team['24h']) && $load_user_in_team['24h'])
		{
			$this->data->is_24h = true;
		}

		$this->data->page['title'] = T_('Request list');
		$this->data->page['desc']  = T_('See list of request registered and status of them. Depending on your permission you can do some actions.');
	}



	// /**
	//  * show one request detail
	//  *
	//  * @param      <type>  $_args  The arguments
	//  */
	// public function view_showRequestDetail($_args)
	// {
	// 	$args                     = [];
	// 	$hour_request_code = null;
	// 	if(isset($_args->match->url[0][2]) && $_args->match->url[0][2])
	// 	{
	// 		$hour_request_code = $_args->match->url[0][2];
	// 	}
	// 	$args['id']                 = $hour_request_code;
	// 	$result                     = $this->model()->request_detail($args);

	// 	$this->data->request_detail = $result;
	// 	$this->data->team_code      = \lib\router::get_url(0);
	// }


	/**
	 * Shows the request list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_hour($_args)
	{
		$args                     = [];
		$args['team']             = \lib\router::get_url(0);
		$args['user']             = utility::get('user');
		$result                   = $this->model()->request_list($args);

		$this->data->request_list = $result;
		$this->data->team_code    = \lib\router::get_url(0);

	}


	// /**
	//  * show time details
	//  *
	//  * @param      <type>  $_args  The arguments
	//  */
	// public function view_showTime($_args)
	// {
	// 	$hour_code = null;
	// 	if(isset($_args->match->url[0][3]) && $_args->match->url[0][3])
	// 	{
	// 		$hour_code = $_args->match->url[0][3];
	// 	}

	// 	if($hour_code)
	// 	{
	// 		$args            = [];
	// 		$args['id']      = $hour_code;
	// 		$args['hour_id'] = $hour_code;
	// 		$args['team']    = \lib\router::get_url(0);
	// 		$myTime = $this->model()->getMyTime($args);
	// 		$this->data->myTime = $myTime;
	// 	}
	// }
}
?>