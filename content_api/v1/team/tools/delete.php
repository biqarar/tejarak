<?php
namespace content_api\v1\team\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait delete
{

	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function delete_team($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}

		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:team:delete:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		$team_details = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'delete']);
		if(!$team_details || !isset($team_details['id']))
		{
			logs::set('api:team:delete:permission:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to delete this team"), 'id', 'permission');
			return false;
		}

		if(\lib\db\teams::update(['status' => 'deleted'], $team_details['id']))
		{
			$log_meta['meta']['team'] = $team_details;
			logs::set('api:team:delete:team:complete', $this->user_id, $log_meta);
			debug::title(T_("Operation Complete"));
			debug::warn(T_("The team was deleted"));
		}

	}
}
?>