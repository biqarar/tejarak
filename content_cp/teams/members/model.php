<?php
namespace content_cp\teams\members;
use \lib\utility;
use \lib\debug;

class model extends \mvc\model
{
	public function members_list($_args, $_fields)
	{
		$team_id            = \lib\router::get_url(2);

		$meta               = [];
		$meta['admin']      = true;
		$meta['team_id']    = $team_id;
		$meta['pagenation'] = false;
		$meta['end_limit']  = 1000;

		$url_property       = \lib\router::$url_array_property;

		foreach ($url_property as $key => $value)
		{
			if(preg_match("/\=/", $value))
			{
				$split = explode('=', $value);
				if($split[0] == 'page')
				{
					continue;
				}
				$meta[$split[0]] = $split[1];
			}
		}

		$search = null;
		if(utility::get('search'))
		{
			$search = utility::get('search');
		}

		$result = \lib\db\userteams::search($search, $meta);

		return $result;
	}
}
?>
