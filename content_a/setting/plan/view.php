<?php
namespace content_a\setting\plan;

class view
{


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function config()
	{
		\dash\data::currentPlan(\content_a\setting\plan\model::plan());

		$myTeam = 'myTeam';

		$teamCode = \dash\coding::encode(\dash\data::currentPlan_team_id());
		$currentTeam = \lib\app\team::getTeamDetail($teamCode);

		if(isset($currentTeam['name']))
		{
			$myTeam = $currentTeam['name'];
		}

		\dash\data::page_title(T_('Setting | '). T_('Change Plan of :name', ['name' => $myTeam]));
		\dash\data::page_desc(T_('By choose new plan, we generate your invoice until now and next invoice is created one month later exactly at this time and you can pay it from billing.'));
	}
}
?>