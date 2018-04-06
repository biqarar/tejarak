<?php
namespace content_api\v1\team;


class model extends \addons\content_api\v1\home\model
{
	use tools\add;
	use tools\get;
	use tools\delete;
	use tools\close;


	/**
	 * Posts a team.
	 * insert new team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_team()
	{
		return $this->add_team();
	}


	/**
	 * patch the ream
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function patch_team()
	{
		return $this->add_team(['method' => 'patch']);
	}


	/**
	 * Gets one team.
	 *
	 * @return     <type>  One team.
	 */
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
				'input' => \lib\utility::request(),
			]
		];


		if(!$this->user_id)
		{
			\lib\notif::error(T_("User id not found"));
			return false;
		}
		$code  = \lib\utility::request('id');
		$group = \lib\utility::request('group');

		if(!$code)
		{
			\dash\db\logs::set('api:team:telegram:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("id not set"), 'id', 'arguments');
			return false;
		}

		if(!$group)
		{
			\dash\db\logs::set('api:team:telegram:group:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("group not set"), 'group', 'arguments');
			return false;
		}

		$load_team = \lib\db\teams::access_team_code($code,$this->user_id, ['action'=> 'edit']);

		if(!isset($load_team['team_id']))
		{
			\lib\notif::error(T_("Can not access to load this team"), 'id', 'arguments');
			return false;
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
				'old'   => $load_team,
			]
		];

		\dash\db\logs::set('api:team:telegram:group:changed', $this->user_id, $log_meta);
		\lib\db\teams::update(['telegram_id' => $group], $load_team['team_id']);

		// \lib\notif::title(T_("Operation complete"));
	}
}
?>