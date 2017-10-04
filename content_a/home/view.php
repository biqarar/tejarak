<?php
namespace content_a\home;

class view extends \content_a\main\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_("Dashboard");
	}


	/**
	 * view all team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_dashboard($_args)
	{
		$team_list = $this->model()->team_list();


		if(is_array($team_list))
		{
			$ids          = array_column($team_list, 'id');
			$team_list    = array_combine($ids, $team_list);
			$ids          = array_map(function($_a){return \lib\utility\shortURL::decode($_a);}, $ids);
			$session_team_list_time = \lib\session::get('team_list_detail_time');
			if(time() - intval($session_team_list_time) > 60)
			{
				$static_count = \lib\db\teams::count_detail($ids, true);
				\lib\session::set('team_list_detail', $static_count);
				\lib\session::set('team_list_detail_time', time());
			}
			else
			{
				$static_count = \lib\session::get('team_list_detail');
			}

			foreach ($team_list as $key => $value)
			{
				if(array_key_exists($key, $static_count))
				{
					$team_list[$key]['stats'] = $static_count[$key];
				}
			}
		}

		$this->data->team_list = $team_list;
	}
}
?>