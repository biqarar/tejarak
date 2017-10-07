<?php
namespace content_a\teamdashboard;

class view extends \content_a\main\view
{
	public function config()
	{

		parent::config();
		$team_name = '';
		if(isset($this->data->current_team['name']))
		{
			$team_name = $this->data->current_team['name'];
		}
		$this->data->page['title'] = T_('Dashboard of :name', ['name'=> $team_name]);
		$this->data->page['desc'] = T_('Glance at your team summary and compare some important data together and enjoy Tejarak!'). ' '. T_('Have a good day;)');

		$team_id = \lib\utility\shortURL::decode(\lib\router::get_url(0));

		$dashboard_detail = \lib\db\teams::dashboard_detail($team_id, $this->login('id'));
		if(isset($dashboard_detail['last_time_chart']) && is_array($dashboard_detail['last_time_chart']))
		{
			$chart = [];
			foreach ($dashboard_detail['last_time_chart'] as $key => $value)
			{
				$date = $key;
				if(\lib\define::get_language() === 'fa')
				{
					$date = \lib\utility\jdate::date("Y-m-d", strtotime($date), false);
				}
				array_push($chart, ['key' => $date, 'value' => $value]);
			}
			$dashboard_detail['last_time_chart'] = json_encode($chart, JSON_UNESCAPED_UNICODE);
		}

		$this->data->dashboard_detail = $dashboard_detail;

		// var_dump($this->data->current_team);
		// exit();
	}
}
?>