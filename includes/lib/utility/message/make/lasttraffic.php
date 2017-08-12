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
		$result          = \lib\db\hours::search(null, $meta);

		$msg = null;
		if($result && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if(isset($value['displayname']))
				{
					$msg .= "\n". $value['displayname'];
					if(array_key_exists('end', $value) && array_key_exists('start', $value))
					{
						if($value['end'])
						{
							$msg .= "🌑 ". human::number(preg_replace("/\:00$/", '', $value['end']), \lib\define::get_language());

						}
						else
						{
							$msg .= "🌖 ". human::number(preg_replace("/\:00$/", '', $value['start']), \lib\define::get_language());
						}
					}
				}
			}
		}
		return $msg;
	}

}
?>