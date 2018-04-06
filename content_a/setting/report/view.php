<?php
namespace content_a\setting\report;

class view extends \content_a\setting\view
{

	public function config()
	{
		parent::config();
		$this->data->page['title']  = T_('Setting'). ' | '. T_('Reports');
		$this->data->page['desc']  = T_('Manage report, set header and footer, set automatic report and manage telegram group and syncing.');
	}

	/**
	 * { function_description }
	 */
	public function view_report()
	{
		$this->data->server_timezone = \lib\utility\timezone::current();

		$team_code = \dash\url::dir(0);
		$team_id   = \lib\coding::decode($team_code);

		if(!$team_id)
		{
			return false;
		}

		$args               = [];
		$args['id']         = \dash\url::dir(0);
		$admins             = \lib\db\userteams::get_admins($args);
		$this->data->admins = $admins;
		$current_teams = \lib\db\teams::get_by_id($team_id);

		if(isset($current_teams['reportheader']))
		{
			$this->data->reportHeader = $current_teams['reportheader'];
		}

		$this->data->current_teams = $current_teams;

		if(isset($current_teams['reportfooter']))
		{
			$this->data->reportFooter = $current_teams['reportfooter'];
		}

		$report_settings = [];

		if(isset($current_teams['meta']) && is_string($current_teams['meta']) && substr($current_teams['meta'], 0,1) === '{')
		{
			$meta = json_decode($current_teams['meta'], true);
			if(isset($meta['report_settings']))
			{
				$report_settings = $meta['report_settings'];
			}
		}

		if(isset($current_teams['telegram_id']) && $current_teams['telegram_id'])
		{
			$this->data->telegram_id = $current_teams['telegram_id'];
		}

		$this->data->report_settings = $report_settings;

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>