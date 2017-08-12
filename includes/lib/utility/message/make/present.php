<?php
namespace lib\utility\message\make;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;


trait present
{

	public function present()
	{
		$result = \lib\db\teams::get_active_member($this->team_id);
		$msg = null;
		if($result && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if(isset($value['displayname']))
				{
					$msg .= "\n🔷 ".  $value['displayname'];
				}
			}
		}

		if($msg)
		{
			$msg = "#". T_("Absents"). "\n". \lib\utility::date('l j F Y H:i', time() , 'current') . "\n\n". $msg;
			$msg .= "\n👥 ". human::number(count($result), \lib\define::get_language());
		}
		return $msg;
	}
}
?>