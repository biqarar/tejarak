<?php
namespace lib\utility\message\make;
use \lib\utility\human;

trait first_enter
{

	/**
	 * make first_enter message
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public function first_enter()
	{
		$msg = null;

		// check group settings to send first member name
		if(
			isset($this->team_meta['report_settings']['telegram_group']) &&
			isset($this->team_meta['report_settings']['first_member_name']) &&
			$this->team_meta['report_settings']['telegram_group'] &&
			$this->team_meta['report_settings']['first_member_name'] &&
			$this->displayname
		  )
		{
			$msg = \lib\utility::date('l j F Y', time() , 'current');
			$msg .= "\n";
			$msg .= "💪 ". $this->displayname;
			$msg .= "\n"."🌖 🌱 👨‍💻 🥇";
		}

		return $msg;
	}
}

?>