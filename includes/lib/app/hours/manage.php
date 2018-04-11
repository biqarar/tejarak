<?php
namespace lib\app\hours;


trait manage
{

	/**
	 * change hour type
	 * all
	 * nothing
	 * base
	 * wplus
	 * wminus
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function hour_change_type($_args = [])
	{
		$default_args =
		[
			'method' => 'patch'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		// // \dash\notif::title(T_("Operation Faild"));

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		if(!\dash\user::id())
		{
			\dash\db\logs::set('api:hours:change:user_id:notfound', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$hour_id = \dash\app::request('hour_id');
		$hour_id = \dash\coding::decode($hour_id);
		if(!$hour_id)
		{
			\dash\db\logs::set('api:hours:change:hour_id:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Hour id not set"), 'hour_id', 'arguments');
			return false;
		}

		$type = \dash\app::request('type');
		if(!$type || $type === '' || $type == '')
		{
			\dash\db\logs::set('api:hours:change:type:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Type not set"), 'type', 'arguments');
			return false;
		}

		if(!in_array($type, ['all', 'wplus', 'wminus', 'nothing', 'base']))
		{
			\dash\db\logs::set('api:hours:change:type:invalid', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid type"), 'type', 'arguments');
			return false;
		}

		// load hour record
		$get_hour_record = \lib\db\hours::get(['id' => $hour_id, 'limit' => 1]);
		if
		(
			!$get_hour_record ||
			!isset($get_hour_record['userteam_id']) ||
			!isset($get_hour_record['id']) ||
			!isset($get_hour_record['type']) ||
			!array_key_exists('diff', $get_hour_record) ||
			!array_key_exists('total', $get_hour_record) ||
			!array_key_exists('minus', $get_hour_record) ||
			!array_key_exists('plus', $get_hour_record) ||
			!array_key_exists('accepted', $get_hour_record)
		)
		{
			\dash\db\logs::set('api:hours:change:hour_id:record:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid hour id"), 'hour_id', 'arguments');
			return false;
		}
		// load userteam
		$get_userteam_record = \lib\db\userteams::get(['id' => $get_hour_record['userteam_id'], 'limit' => 1]);
		if(!$get_userteam_record || !isset($get_userteam_record['team_id']))
		{
			\dash\db\logs::set('api:hours:change:hour_id:team:record:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Team detail not found"), 'hour_id', 'system');
			return false;
		}

		// load team data
		$team_detail = \lib\db\teams::access_team_id($get_userteam_record['team_id'], \dash\user::id(), ['action' => 'admin']);

		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			\dash\db\logs::set('api:hours:change:team:access', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Can not access to set time of this team"), 'team', 'permission');
			return false;
		}

		$update   = [];

		$diff     = floatval($get_hour_record['diff']);
		$total    = floatval($get_hour_record['total']);
		$minus    = floatval($get_hour_record['minus']);
		$plus     = floatval($get_hour_record['plus']);
		$accepted = floatval($get_hour_record['accepted']);

		if($_args['method'] === 'patch')
		{
			switch ($type)
			{
				case 'nothing':
					$accepted = 0;
					break;

				case 'all':
					$accepted = ($diff + $plus) - $minus;
					break;

				case 'wplus':
					$accepted = ($diff + $plus);
					break;

				case 'wminus':
					$accepted = $diff - $minus;
					break;

				case 'base':
					$accepted = $diff;
					break;
			}

			$update['type']   = $type;
			$update['accepted'] = $accepted;
			\lib\db\hours::update($update, $get_hour_record['id']);
		}
		else
		{
			\dash\db\logs::set('api:hours:change:method:invalid', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid method of api"), 'method', 'permission');
			return false;
		}

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Hour type changed"));
		}
	}
}
?>