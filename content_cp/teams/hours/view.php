<?php
namespace content_cp\teams\hours;

class view
{
	public static function config()
	{
		$list = self::hours_list();
		\dash\data::hoursList($list);
	}


	public static function hours_list()
	{
		$team_id           = \dash\request::get('id');

		$meta              = [];
		$meta['admin']     = true;
		$meta['team_id']   = $team_id;
		$meta['limit']     = 100;
		$meta['end_limit'] = 100;

		$search = null;
		if(\dash\request::get('search'))
		{
			$search = \dash\request::get('search');
		}

		$result = \lib\db\hourlogs::search($search, $meta);

		return $result;
	}
}
?>