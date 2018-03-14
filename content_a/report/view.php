<?php
namespace content_a\report;
use \lib\utility;

class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->month = \lib\utility\date::month_precent();
		/**
		* get raw time
		* skip humantime
		*/
		if(\lib\utility::get('time') === 'raw')
		{
			$this->data->time_raw = true;
		}
		else
		{
			$this->data->time_raw = false;
		}

		if(utility::get())
		{
			if(!utility::get('export'))
			{
				$this->data->export_url = \lib\url::pwd(). '&export=true';
			}
			else
			{
				$this->data->export_url = \lib\url::pwd();
			}
		}
		else
		{
			$this->data->export_url = \lib\url::pwd(). '?export=true';
		}

		if(utility::get('year') && is_numeric(utility::get('year')) && mb_strlen(utility::get('year')) === 4)
		{
			$this->data->get_year = utility::get('year');
		}


		$this->data->page['title'] = T_('Reports');
		$this->data->page['desc']  = T_('You can see reports and compare data of members and give export from report to use in another programs.');

		$all_user = [];

		if($team_code = \lib\temp::get('team_code_url'))
		{
			$this->data->reportUrl = \lib\url::here(). '/'. \lib\router::get_url();
			// var_dump($this->data->reportUrl);exit();
			$team_id = \lib\utility\shortURL::decode($team_code);
			if($team_id)
			{
				// check admin or user of team
				$user_status = \lib\db\userteams::get(
				[
					'user_id' => $this->login('id'),
					'team_id' => $team_id,
					'limit'   => 1
				]);

				if(isset($user_status['rule']) && $user_status['rule'] === 'admin')
				{
					// this user is admin
					// set true on show_all_user
					$this->data->show_all_user = true;
					// load all user data to show
					$all_user = $this->model()->listMember($team_id);
					$all_user_id = array_column($all_user, 'user_id');
					$all_user    = array_combine($all_user_id, $all_user);
					$this->data->all_user_list = $all_user;
				}
				else
				{
					$this->data->show_all_user = false;
					$this->data->all_user_list = [];
					// this user is user
				}
			}
		}

		if(utility::get('user') && isset($all_user[utility::get('user')]))
		{
			$this->data->report_current_user = $all_user[utility::get('user')];
		}

		$team_id = \lib\utility\shortURL::decode($this->data->team_code);

		$cache_chart = \lib\session::get('report_last_month_chart_'. $team_id);
		if($cache_chart === null)
		{

			if($this->data->is_admin)
			{
				$user_id = null;
			}
			else
			{
				$user_id = \lib\user::id();
			}

			$chart_last_month = \lib\db\teams::last_time_chart($team_id, $user_id, 30);
			$cache_chart = [];

			if(is_array($chart_last_month))
			{
				foreach ($chart_last_month as $key => $value)
				{
					$format = "Y-m-d D";
					$date = date($format, strtotime($key));
					if(\lib\define::get_language() === 'fa')
					{
						$date = \lib\utility\jdate::date($format, strtotime($key), false);
					}

					$cache_chart[] = ['key' => $date, 'value' => $value];
				}
			}
			$cache_chart = json_encode($cache_chart, JSON_UNESCAPED_UNICODE);
			\lib\session::set('report_last_month_chart_'. $team_id, $cache_chart, null, 60);
		}
		$this->data->chart_last_month = $cache_chart;

	}
}
?>