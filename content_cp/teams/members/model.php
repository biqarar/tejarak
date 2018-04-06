<?php
namespace content_cp\teams\members;


class model extends \mvc\model
{
	public function members_list($_args, $_fields)
	{
		$team_id            = \dash\url::dir(2);

		$meta               = [];
		$meta['admin']      = true;
		$meta['team_id']    = $team_id;
		$meta['pagenation'] = false;
		$meta['end_limit']  = 1000;

		$url_property       = \dash\url::dir();

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
		if(\dash\request::get('search'))
		{
			$search = \dash\request::get('search');
		}

		$result = \lib\db\userteams::search($search, $meta);

		return $result;
	}
}
?>
