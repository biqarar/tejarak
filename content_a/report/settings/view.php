<?php
namespace content_a\report\settings;


class view extends \content_a\report\view
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

		if(isset($team_details['reportfooter']))
		{
			$this->data->reportFooter = $team_details['reportfooter'];
		}

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>