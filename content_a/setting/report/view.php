<?php
namespace content_a\setting\report;

class view
{

	public static function config()
	{

		\dash\data::page_title(T_('Setting'). ' | '. T_('Reports'));
		\dash\data::page_desc(T_('Manage report, set header and footer, set automatic report and manage telegram group and syncing.'));

		\dash\data::serverTimezone(\dash\utility\timezone::current());

		$teamCode = \dash\request::get('id');
		$team_id   = \dash\coding::decode($teamCode);

		if(!$team_id)
		{
			return false;
		}

		$args               = [];
		$args['id']         = \dash\request::get('id');
		$admins             = \lib\db\userteams::get_admins($args);
		\dash\data::admins($admins);

		$currentTeams = \lib\db\teams::get_by_id($team_id);

		if(isset($currentTeams['reportheader']))
		{
			\dash\data::reportHeader($currentTeams['reportheader']);
		}

		\dash\data::currentTeams($currentTeams);

		if(isset($currentTeams['reportfooter']))
		{
			\dash\data::reportFooter($currentTeams['reportfooter']);
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
			\dash\data::telegram_id($currentTeams['telegram_id']);
		}

		\dash\data::report_settings($report_settings);

	}
}
?>