<?php
namespace content_a\houredit;

class view extends \content_a\main\view
{

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
		$args['user']             = \lib\utility\shortURL::encode($this->login('id'));
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