<?php
namespace lib\app\member;


trait add
{
	private static $master_user_id         = null;
	private static $OLD_USER_ID            = null;
	private static $old_user_id            = null;
	private static $NEW_USER_ID            = null;
	private static $userteam_record_detail = [];

	/**
	 * Adds a member.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function add_member($_args = [])
	{

		// ready to insert userteam or userbranch record
		$args = [];

		// default args
		$default_args =
		[
			'method'             => 'post',
			'have_user_id'       => null,
			'update_all_user_id' => false,
			'debug'              => true,
			'save_log'           => true,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}
		// merge default args and args
		$_args = array_merge($default_args, $_args);

		// set default title of debug
		// if($_args['debug']) // \dash\notif::title(T_("Operation Faild"));

		// delete member mode
		$delete_mode = false;

		// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'user_id' => \dash\user::id(),
				'input'   => \dash\app::request(),
			]
		];

		// check user id is exist
		if(!\dash\user::id())
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:user_id:notfound', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("User not found"), 'user', 'permission');
			return false;
		}


		// get team and check it
		$team_id = \dash\app::request('team');
		$team_id = \dash\coding::decode($team_id);
		if(!$team_id)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:team:not:set', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("Team not set"), 'team', 'arguments');
			return false;
		}

		/**
		 * check and set the args
		 */
		$return_function = self::check_args($_args, $args, $log_meta, $team_id);

		if(!\dash\engine\process::status() || $return_function === false)
		{
			return false;
		}

		$check_security = self::check_security($team_id, $_args, $args, $log_meta);

		if($check_security === false || !\dash\engine\process::status())
		{
			return false;
		}

		$res = self::find_member_id($_args, $log_meta, $team_id);

		if(!\dash\engine\process::status() || $res === false)
		{
			return false;
		}


		if($_args['method'] === 'post')
		{
			$args['team_id']       = $team_id;
		}

		if(self::$master_user_id)
		{
			$args['user_id']       = self::$master_user_id;
		}

		// check file is set or no
		// if file is not set and the user have a file load the default file
		if(self::$master_user_id && $_args['method'] === 'post' && ((!$args['fileid'] && !$args['avatar']) || (!$args['firstname'] || !$args['lastname'])))
		{
			$user_detail = \dash\db\users::get(['id' => $args['user_id'], 'limit' => 1]);
			if(isset($user_detail['fileid']))
			{
				$args['fileid'] = $user_detail['fileid'];
			}

			if(isset($user_detail['avatar']))
			{
				$args['avatar'] = $user_detail['avatar'];
			}

			if(isset($user_detail['name']) && !$args['firstname'])
			{
				$args['firstname'] = $user_detail['name'];
			}

			if(isset($user_detail['lastname']) && !$args['lastname'])
			{
				$args['lastname'] = $user_detail['lastname'];
			}
		}



		$return = [];

		// insert new user team
		if($_args['method'] === 'post')
		{
			$user_team_id          = \lib\db\userteams::insert($args);
			$return['userteam_id'] = \dash\coding::encode($user_team_id);
			$return['user_id']     = \dash\coding::encode(self::$master_user_id);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = \dash\app::request('id');
			$id = \dash\coding::decode($id);
			if(!$id)
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:pathc:id:not:set', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			if(self::$OLD_USER_ID && self::$NEW_USER_ID && intval(self::$OLD_USER_ID) !== intval(self::$NEW_USER_ID))
			{
				// old user id and new user id is set but different
				// we must update all user id in main parent of this team
				\lib\db\userteams::update_all_user_id(self::$OLD_USER_ID, self::$NEW_USER_ID, $team_id, $log_meta);
				if(!\dash\engine\process::status())
				{
					return false;
				}
			}

			unset($args['team_id']);
			if(!\dash\app::isset_request('postion'))               unset($args['postion']);
			if(!\dash\app::isset_request('personnel_code'))        unset($args['personnelcode']);
			if(!\dash\app::isset_request('24h'))                   unset($args['24h']);
			if(!\dash\app::isset_request('remote_user'))           unset($args['remote']);
			if(!\dash\app::isset_request('is_default'))            unset($args['isdefault']);
			if(!\dash\app::isset_request('date_enter'))            unset($args['dateenter']);
			if(!\dash\app::isset_request('date_exit'))             unset($args['dateexit']);
			if(!\dash\app::isset_request('firstname'))             unset($args['firstname']);
			if(!\dash\app::isset_request('lastname'))              unset($args['lastname']);
			if(!\dash\app::isset_request('file'))                  unset($args['fileid'], $args['avatar']);
			if(!\dash\app::isset_request('allow_plus'))            unset($args['allowplus']);
			if(!\dash\app::isset_request('allow_minus'))           unset($args['allowminus']);
			if(!\dash\app::isset_request('status'))                unset($args['status']);
			if(!\dash\app::isset_request('displayname'))           unset($args['displayname']);
			if(!\dash\app::isset_request('rule'))                  unset($args['rule']);
			if(!\dash\app::isset_request('visibility'))            unset($args['visibility']);
			if(!\dash\app::isset_request('allow_desc_enter'))      unset($args['allowdescenter']);
			if(!\dash\app::isset_request('allow_desc_exit'))       unset($args['allowdescexit']);

			if(!\dash\app::isset_request('national_code'))         unset($args['nationalcode']);
			if(!\dash\app::isset_request('father'))                unset($args['father']);
			if(!\dash\app::isset_request('birthday'))              unset($args['birthday']);
			if(!\dash\app::isset_request('gender'))                unset($args['gender']);
			if(!\dash\app::isset_request('type'))                  unset($args['type']);
			if(!\dash\app::isset_request('marital'))               unset($args['marital']);
			if(!\dash\app::isset_request('child'))                 unset($args['childcount']);
			if(!\dash\app::isset_request('birthcity'))             unset($args['birthplace']);
			if(!\dash\app::isset_request('shfrom'))                unset($args['from']);
			if(!\dash\app::isset_request('shcode'))                unset($args['shcode']);
			if(!\dash\app::isset_request('education'))             unset($args['education']);
			if(!\dash\app::isset_request('job'))                   unset($args['job']);
			if(!\dash\app::isset_request('passport_code'))         unset($args['pasportcode']);

			if(!\dash\app::isset_request('payment_account_number'))unset($args['cardnumber']);
			if(!\dash\app::isset_request('shaba'))                 unset($args['shaba']);

			if(array_key_exists('rule', $args) && !in_array($args['rule'], ['user', 'admin', 'gateway']))
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:rule:invalid:edit', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Invalid parameter rule"), 'rule', 'arguments');
				return false;
			}

			if(array_key_exists('status', $args) && !in_array($args['status'], ['active', 'deactive', 'suspended']))
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:status:invalid:edit', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Invalid parameter status"), 'status', 'arguments');
				return false;
			}

			if(array_key_exists('visibility', $args) && !in_array($args['visibility'], ['visible', 'hidden']))
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:visibility:invalid', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Invalid parameter visibility"), 'visibility', 'arguments');
				return false;
			}
			// check barcode, qrcode and rfid,
			// update it if changed
			// get from \dash\app::request()
			// check from $args
			self::check_barcode($id);
			// if have error in checking barcode
			if(!\dash\engine\process::status())
			{
				return;
			}

			if(!empty($args))
			{
				\lib\db\userteams::update($args, $id);
			}

			if(\dash\engine\process::status())
			{
				$return = true;
			}
		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\members::remove($args);
		}

		if(\dash\engine\process::status())
		{
			// if($_args['debug']) // \dash\notif::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				if($_args['debug']) \dash\notif::ok(T_("Member successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				if($_args['debug']) \dash\notif::ok(T_("Member successfully updated"));
			}
			else
			{
				if($_args['debug']) \dash\notif::ok(T_("Member successfully removed"));
			}
		}

		return $return;
	}
}
?>