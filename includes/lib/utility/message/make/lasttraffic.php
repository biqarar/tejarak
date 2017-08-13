<?php
namespace lib\utility\message\make;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;


trait lasttraffic
{

	public function lasttraffic()
	{
		$meta            = [];
		$meta['limit']   = 10;
		$meta['team_id'] = $this->team_id;
		$meta['sort']    = 'id';
		$meta['order']   = 'desc';
		$result          = \lib\db\hourlogs::search(null, $meta);

		$msg = null;
		if($result && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if(isset($value['displayname']))
				{
					$msg .= "\n". $value['displayname'];
					if(array_key_exists('type', $value) && array_key_exists('time', $value))
					{

						if($value['type'] === 'exit')
						{
							$msg .= " ➡️ ". human::number(preg_replace("/\:00$/", '', $value['time']), \lib\define::get_language());

						}
						else
						{
							$msg .= " ⬅️ ". human::number(preg_replace("/\:00$/", '', $value['time']), \lib\define::get_language());
						}
					}
				}
			}
		}

		if($msg)
		{
			$msg = "#". T_("Last_traffic"). "\n". \lib\utility::date('l j F Y H:i', time() , 'current') . "\n\n". $msg;
			$msg .= "\n👥 ". human::number(count($result), \lib\define::get_language());
		}

		return $msg;
	}

}
?>