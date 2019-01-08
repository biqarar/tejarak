<?php
namespace content_a\teams;

class view
{
	public static function config()
	{

		$list = self::teams_list();

		\dash\data::teamsList($list);

	}


	public static function teams_list()
	{
		$meta   = [];
		$meta['admin'] = true;

		$search = null;
		if(\dash\request::get('search'))
		{
			$search = \dash\request::get('search');
		}

		$result = \lib\db\teams::search($search, $meta);

		return $result;
	}
}
?>