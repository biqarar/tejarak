<?php
namespace content_a\houredit;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{
	public function getMyTime($_args)
	{
		utility::set_request_array($_args);
		$this->user_id = $this->login('id');
		return $this->get_hours();
	}
}
?>