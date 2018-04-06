<?php
namespace content_api\v1\team\tools;


trait close
{

	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function close_team($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}

		// \lib\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		$id = \lib\utility::request("id");
		$id = \dash\coding::decode($id);
		if(!$id)
		{
			\dash\db\logs::set('api:team:delete:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		$team_details = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'close']);
		if(!$team_details || !isset($team_details['id']))
		{
			\dash\db\logs::set('api:team:delete:permission:denide', $this->user_id, $log_meta);
			\lib\notif::error(T_("Can not access to delete this team"), 'id', 'permission');
			return false;
		}

		if(\lib\db\teams::update(['status' => 'close'], $team_details['id']))
		{
			$log_meta['meta']['team'] = $team_details;
			\dash\db\logs::set('api:team:delete:team:complete', $this->user_id, $log_meta);
			// \lib\notif::title(T_("Operation Complete"));
			\lib\notif::warn(T_("The team was closed"));
		}

	}
}
?>