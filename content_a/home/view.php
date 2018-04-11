<?php
namespace content_a\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Dashboard"));
		\dash\data::page_desc(T_("View team summary and add new team or change it"));
		$team_list = null;
		if(\dash\user::login())
		{
			$team_list = \lib\app\team::get_list_team();
		}

		if(is_array($team_list))
		{
			$ids          = array_column($team_list, 'id');
			$team_list    = array_combine($ids, $team_list);
			$ids          = array_map(function($_a){return \dash\coding::decode($_a);}, $ids);
			$session_team_list_time = \dash\session::get('team_list_detail_time');
			if(time() - intval($session_team_list_time) > 60)
			{
				$static_count = \lib\db\teams::count_detail($ids, true);
				\dash\session::set('team_list_detail', $static_count);
				\dash\session::set('team_list_detail_time', time());
			}
			else
			{
				$static_count = \dash\session::get('team_list_detail');
			}

			if(is_array($static_count))
			{
				foreach ($team_list as $key => $value)
				{
					if(array_key_exists($key, $static_count))
					{
						$team_list[$key]['stats'] = $static_count[$key];
					}
				}
			}
		}

		\dash\data::teamList($team_list);
	}
}
?>