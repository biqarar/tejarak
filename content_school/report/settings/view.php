<?php
namespace content_school\report\settings;


class view extends \content_school\report\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_('Report settings');
		$this->data->page['desc']  = $this->data->page['title'];
	}

	/**
	 * { function_description }
	 */
	public function view_settings()
	{
		$this->data->server_timezone = \lib\utility\timezone::current();

		$team_code = \lib\router::get_url(0);
		$team_id   = \lib\utility\shortURL::decode($team_code);

		if(!$team_id)
		{
			return false;
		}

		$args               = [];
		$args['id']         = \lib\router::get_url(0);
		$admins             = \lib\db\userteams::get_admins($args);
		$this->data->admins = $admins;
		$team_details = \lib\db\teams::get_by_id($team_id);

		if(isset($team_details['reportheader']))
		{
			$this->data->reportHeader = $team_details['reportheader'];
		}

		$this->data->team_details = $team_details;

		if(isset($team_details['reportfooter']))
		{
			$this->data->reportFooter = $team_details['reportfooter'];
		}

		$report_settings = [];

		if(isset($team_details['meta']) && is_string($team_details['meta']) && substr($team_details['meta'], 0,1) === '{')
		{
			$meta = json_decode($team_details['meta'], true);
			if(isset($meta['report_settings']))
			{
				$report_settings = $meta['report_settings'];
			}
		}

		if(isset($team_details['telegram_id']) && $team_details['telegram_id'])
		{
			$this->data->telegram_id = $team_details['telegram_id'];
		}

		$this->data->report_settings = $report_settings;

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>