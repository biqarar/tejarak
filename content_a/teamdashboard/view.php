<?php
namespace content_a\teamdashboard;

class view extends \content_a\main\view
{
	public function config()
	{
		$team_name = '';
		if(isset($this->data->current_team['name']))
		{
			$team_name = $this->data->current_team['name'];
		}
		$this->data->page['title'] = T_('Dashboard of :name', ['name'=> $team_name]);
		$this->data->page['desc'] = T_('Glance at your team summary and compare some important data together and enjoy Tejarak!'). ' '. T_('Have a good day;)');

		$team_id = \lib\utility\shortURL::decode(\lib\url::dir(0));

		if(time() - intval(\lib\session::get('last_time_chart_time_'. (string) $team_id )) > 60)
		{
			$dashboard_detail = \lib\db\teams::dashboard_detail($team_id, \lib\user::id());
			\lib\session::set('last_time_chart'. (string) $team_id , $dashboard_detail);
			\lib\session::set('last_time_chart_time_'. (string) $team_id , time());
		}
		else
		{
			$dashboard_detail = \lib\session::get('last_time_chart'. (string) $team_id );
		}


		if(isset($dashboard_detail['last_time_chart']) && is_array($dashboard_detail['last_time_chart']))
		{
			$chart = [];
			foreach ($dashboard_detail['last_time_chart'] as $key => $value)
			{
				$date = $key;
				if(\lib\language::current() === 'fa')
				{
					$date = \lib\utility\jdate::date("Y-m-d", strtotime($date), false);
				}
				array_push($chart, ['key' => $date, 'value' => $value]);
			}
			$dashboard_detail['last_time_chart'] = json_encode($chart, JSON_UNESCAPED_UNICODE);
		}
		$dashboard_detail['month_detail'] = \lib\utility\date::month_precent();

		$this->data->dashboard_detail = $dashboard_detail;

		// var_dump($this->data->current_team);
		// exit();
	}
}
?>