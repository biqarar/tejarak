<?php
namespace content_cp\teams\members;

class view
{
	public static function config()
	{
		$list = self::members_list();
		\dash\data::membersList($list);
	}


	public static function members_list()
	{
		$team_id            = \dash\request::get('id');

		$meta               = [];
		$meta['admin']      = true;
		$meta['team_id']    = $team_id;
		$meta['pagenation'] = false;
		$meta['end_limit']  = 1000;

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