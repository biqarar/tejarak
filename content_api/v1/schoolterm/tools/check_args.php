<?php
namespace content_api\v1\schoolterm\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait check_args
{
	public function schoolterm_check_args($_args, &$args, $log_meta)
	{
			// get firsttitle
		$title = utility::request("title");
		$title = trim($title);
		if($title && mb_strlen($title) > 50)
		{
			logs::set('api:schoolterm:title:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the title less than 50 character"), 'title', 'arguments');
			return false;
		}


		$desc = utility::request("desc");
		$desc = trim($desc);
		if($desc && mb_strlen($desc) > 1000)
		{
			logs::set('api:schoolterm:desc:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the desc less than 1000 character"), 'desc', 'arguments');
			return false;
		}

		$start = utility::request('start');
		if(!$start)
		{
			logs::set('api:schoolterm:start:not:set', $this->user_id, $log_meta);
			debug::error(T_("Start time of terms can not be null"), 'start', 'arguments');
			return false;
		}

		if(strtotime($start) === false)
		{
			logs::set('api:schoolterm:start:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid start time of terms"), 'start', 'arguments');
			return false;
		}

		$start = date("Y-m-d", strtotime($start));

		$end = utility::request('end');
		if(!$end)
		{
			logs::set('api:schoolterm:end:not:set', $this->user_id, $log_meta);
			debug::error(T_("end time of terms can not be null"), 'end', 'arguments');
			return false;
		}

		if(strtotime($end) === false)
		{
			logs::set('api:schoolterm:end:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid end time of terms"), 'end', 'arguments');
			return false;
		}

		$end = date("Y-m-d", strtotime($end));

		$status = utility::request('status');
		if($status && !in_array($status, ['enable', 'disable']))
		{
			logs::set('api:schoolterm:status:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid status of terms"), 'status', 'arguments');
			return false;
		}


		$args['title']  = $title;
		$args['desc']   = $desc;
		$args['start']  = $start;
		$args['end']    = $end;
		$args['status'] = $status;

	}
}
?>