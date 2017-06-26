<?php
namespace content_a\report\sum;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{

	public function sum_report($_args)
	{
		$this->user_id = $this->login('id');
		$_args['id'] = \lib\router::get_url(0);
		utility::set_request_array($_args);
		return $this->report_sum_time();
	}
}
?>