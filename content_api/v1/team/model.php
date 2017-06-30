<?php
namespace content_api\v1\team;
use \lib\debug;
use \lib\utility;
use \lib\db\logs;
class model extends \content_api\v1\home\model
{
	use tools\add;
	use tools\get;
	use tools\delete;


	public function get_one_team()
	{
		return $this->get_team();
	}

	/**
	 * Gets the team list.
	 *
	 * @return     <type>  The team list.
	 */
	public function get_teamList()
	{
		return $this->get_list_team();
	}


	/**
	 * Posts a set telegram group.
	 */
	public function post_setTelegramGroup()
	{
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];


		if(!$this->user_id)
		{
			debug::error(T_("User id not found"));
			return false;
		}
		$code  = utility::request('id');
		$group = utility::request('group');

		if(!$code)
		{
			logs::set('api:team:telegram:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("id not set"), 'id', 'arguments');
			return false;
		}

		if(!$group)
		{
			logs::set('api:team:telegram:group:not:set', $this->user_id, $log_meta);
			debug::error(T_("group not set"), 'group', 'arguments');
			return false;
		}

		$load_team = \lib\db\teams::access_team_code($code,$this->user_id, ['action'=> 'edit']);

		if(!isset($load_team['team_id']))
		{
			debug::error(T_("Can not access to load this team"), 'id', 'arguments');
			return false;
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
				'old'   => $load_team,
			]
		];

		logs::set('api:team:telegram:group:changed', $this->user_id, $log_meta);
		\lib\db\teams::update(['telegram_id' => $group], $load_team['team_id']);

		debug::title(T_("Operation complete"));
	}
}
?>