<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait security
{
	/**
	 * check some thing
	 *
	 * @param      <type>  $_team_id  The team identifier
	 * @param      <type>  $_args     The arguments
	 * @param      <type>  $args      The arguments
	 * @param      <type>  $log_meta  The log meta
	 */
	public function check_security($_team_id, $_args, $args, $log_meta)
	{
		// load team data
		$load_team_data = \lib\db\teams::get_by_id($_team_id);
		if(!$load_team_data || !isset($load_team_data['creator']))
		{
			if($_args['save_log']) logs::set('api:member:team:notfound', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}
		// load the logined user data
		$load_user = \lib\db\users::get(['id' => $this->user_id, 'limit' => 1]);
		if(!$load_user || !isset($load_user['id']))
		{
			if($_args['save_log']) logs::set('api:member:user-id:notfound', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// load logined userteam data
		$user_in_team = \lib\db\userteams::get(['user_id' => $this->user_id, 'team_id' => $_team_id, 'limit' => 1]);
		if(!$user_in_team || !isset($user_in_team['rule']))
		{
			if($_args['save_log']) logs::set('api:member:user-id:notfound', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You not in this team"), 'user', 'permission');
			return false;
		}

		// rule is user can not edit data
		if($user_in_team['rule'] === 'user')
		{
			if($_args['save_log']) logs::set('api:member:user:can:not:edit:member', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can not edit member data"), 'user', 'permission');
			return false;
		}

		// RULE IS ADMIN

		if($_args['method'] === 'post')
		{
			return true;
		}

		$change_id = utility::request('id');
		if(!$change_id)
		{
			if($_args['save_log']) logs::set('api:member:edit:id:not:set:member', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can not edit member data"), 'user', 'permission');
			return false;
		}

		// method is not post and id not found
		$change_id = utility\shortURL::decode($change_id);
		if(!$change_id)
		{
			if($_args['save_log']) logs::set('api:member:id:invalid', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Invalid parameter id"), 'user', 'permission');
			return false;
		}

		$change_id_in_team = $this->userteam_record_detail = \lib\db\userteams::get(['id' => $change_id, 'team_id' => $_team_id, 'limit' => 1]);
		if(!$change_id_in_team || !isset($change_id_in_team['rule']) || !isset($change_id_in_team['user_id']))
		{
			if($_args['save_log']) logs::set('api:member:user-id:notfound', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("User not in this team"), 'user', 'permission');
			return false;
		}

		$is_creator   = false;
		$change_admin = false;

		if(intval($this->user_id) === intval($load_team_data['creator']))
		{
			$is_creator = true;
		}

		if($change_id_in_team['rule'] === 'admin')
		{
			$change_admin = true;
		}

		$access = true;

		if($change_admin && !$is_creator)
		{
			// the creator change her detail
			if(intval($this->user_id) === intval($change_id_in_team['user_id']))
			{
				// the creator sended mobile
				if(utility::request('mobile') && $mobile = utility\filter::mobile(utility::request('mobile')))
				{
					// the creator have old mobile
					if(isset($load_user['mobile']))
					{
						// the old mobile of creator is different by new mobile
						if($mobile != $load_user['mobile'])
						{
							$access = false;
						}
					}
					else
					{
						// the creator have not any mobile!!!
						$access = false;
					}
				}
			}

			if(!$access)
			{
				if($_args['save_log']) logs::set('api:member:admin:can:not:edit:admin', $this->user_id, $log_meta);
				if($_args['debug']) debug::error(T_("Only creator of team can edit admins"), 'user', 'permission');
				return false;
			}
		}


		if($is_creator)
		{
			// the creator change her detail
			if(intval($this->user_id) === intval($change_id_in_team['user_id']))
			{
				// the creator sended mobile
				if(utility::request('mobile') && $mobile = utility\filter::mobile(utility::request('mobile')))
				{
					// the creator have old mobile
					if(isset($load_user['mobile']))
					{
						// the old mobile of creator is different by new mobile
						if($mobile != $load_user['mobile'])
						{
							$access = false;
						}
					}
					else
					{
						// the creator have not any mobile!!!
						$access = false;
					}
				}
			}
		}

		if(!$access)
		{
			if($_args['save_log']) logs::set('api:member:crator:can:not:edit:her:mobile', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can not change your mobile."), 'user', 'permission');
			return false;
		}

		return true;
	}
}
?>