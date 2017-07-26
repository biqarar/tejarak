<?php
namespace content_a\houredit;

class view extends \content_a\main\view
{
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