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
		$this->data->server_timezone = \dash\utility\timezone::current();

		$team_code = \dash\request::get('id');
		$team_id   = \dash\coding::decode($team_code);

		if(!$team_id)
		{
			return false;
		}

		$args               = [];
		$args['id']         = \dash\request::get('id');
		$admins             = \lib\db\userteams::get_admins($args);
		$this->data->admins = $admins;
		$currentTeams = \lib\db\teams::get_by_id($team_id);

		if(isset($currentTeams['reportheader']))
		{
			$this->data->reportHeader = $currentTeams['reportheader'];
		}

		$this->data->currentTeams = $currentTeams;

		if(isset($currentTeams['reportfooter']))
		{
			$this->data->reportFooter = $currentTeams['reportfooter'];
		}

		$report_settings = [];

		if(isset($currentTeams['meta']) && is_string($currentTeams['meta']) && substr($currentTeams['meta'], 0,1) === '{')
		{
			$meta = json_decode($currentTeams['meta'], true);
			if(isset($meta['report_settings']))
			{
				$report_settings = $meta['report_settings'];
			}
		}

		if(isset($currentTeams['telegram_id']) && $currentTeams['telegram_id'])
		{
			$this->data->telegram_id = $currentTeams['telegram_id'];
		}

		$this->data->report_settings = $report_settings;

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>