<?php
namespace content_enter\google;
use \lib\debug;
use \lib\utility;

class model extends \content_enter\main\model
{
	public function get_google()
	{
		if(utility::get('code'))
		{
			$check = \lib\google\google::check();
			var_dump($check);
			if($check)
			{
				$user_data = \lib\google\google::user_info();
				var_dump($user_data);
			}
			else
			{
				return false;
			}
		}
	}
}
?>