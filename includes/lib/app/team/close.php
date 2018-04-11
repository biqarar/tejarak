<?php
namespace lib\app\team;


trait close
{

	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public static function close_team($_args = [])
	{
		if(!\dash\user::id())
		{
			return false;
		}

		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		$id = \dash\app::request("id");
		$id = \dash\coding::decode($id);
		if(!$id)
		{
			\dash\db\logs::set('api:team:delete:id:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		$team_details = \lib\db\teams::access_team_id($id, \dash\user::id(), ['action' => 'close']);
		if(!$team_details || !isset($team_details['id']))
		{
			\dash\db\logs::set('api:team:delete:permission:denide', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Can not access to delete this team"), 'id', 'permission');
			return false;
		}

		if(\lib\db\teams::update(['status' => 'close'], $team_details['id']))
		{
			$log_meta['meta']['team'] = $team_details;
			\dash\db\logs::set('api:team:delete:team:complete', \dash\user::id(), $log_meta);
			// \dash\notif::title(T_("Operation Complete"));
			\dash\notif::warn(T_("The team was closed"));
		}

	}
}
?>