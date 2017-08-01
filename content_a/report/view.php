<?php
namespace content_a\report;

class view extends \content_a\main\view
{
	public function config()
	{
		parent::config();

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

		$this->data->page['title'] = T_('Reports');
		$this->data->page['desc']  = $this->data->page['title'];

		if($team_code = \lib\storage::get_team_code_url())
		{
			$this->data->reportUrl = $this->url('baseFull'). '/'. \lib\router::get_url();
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
	}
}
?>