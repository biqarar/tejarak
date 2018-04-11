<?php
namespace content_a\setting\security;


class model extends \content_a\main\model
{
	public $user_data;
	public $mobile;
	public $user_id;
	public $team_id;
	public $teamCode;
	public $currentTeam;


	/**
	 * Loads a last request.
	 */
	public function load_last_request()
	{
		$team_id = \dash\coding::decode(\dash\request::get('id'));
		$load_last_request = $this->check_sended_request($team_id);
		if(isset($load_last_request['user_id']))
		{
			$user_data             = \dash\db\users::get_by_id($load_last_request['user_id']);
			$result                = [];
			$result['mobile']      = (isset($user_data['mobile'])) ? $user_data['mobile'] : null;
			$result['displayname'] = (isset($user_data['displayname'])) ? $user_data['displayname'] : null;
			$result['avatar']    = (isset($user_data['avatar'])) ? $user_data['avatar'] : null;
			$result['status']      = (isset($load_last_request['status'])) ? $load_last_request['status'] : null;
			$result['id']          = (isset($load_last_request['id'])) ? $load_last_request['id'] : null;
			return $result;
		}
		return false;
	}




	/**
	 * Posts an security.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_security($_args)
	{
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("Please login to change owner"), 'owner');
			return $this->refresh_page();
		}

		// the request was sended
		if($load_last_request = $this->load_last_request())
		{
			if($load_last_request['status'] === 'awaiting')
			{
				if(\dash\request::post('send') === 'ok')
				{
					\dash\db\notifications::update(['status' => 'enable'], $load_last_request['id']);
				}
				elseif(\dash\request::post('send') === 'cancel')
				{
					\dash\db\notifications::update(['status' => 'cancel'], $load_last_request['id']);
				}
			}
			elseif($load_last_request['status'] === 'enable')
			{
				if(\dash\request::post('request') === 'cancel')
				{
					\dash\db\notifications::update(['status' => 'cancel'], $load_last_request['id']);
				}
			}
			return $this->refresh_page();
		}


		$new_owner = \dash\request::post('owner');
		if(!$new_owner)
		{
			\dash\notif::error(T_("Plese fill the mobile field"), 'owner');
			return $this->refresh_page();
		}

		if(!$this->mobile = \dash\utility\filter::mobile($new_owner))
		{
			\dash\notif::error(T_("Invalid mobile number"), 'owner');
			return $this->refresh_page();
		}

		$this->user_data = \dash\db\users::get_by_mobile($this->mobile);
		if(!isset($this->user_data['id']))
		{
			\dash\notif::error(T_("User not found"), 'owner');
			return $this->refresh_page();
		}

		$this->teamCode = \dash\request::get('id');
		$this->team_id = \dash\coding::decode($this->teamCode);
		$this->currentTeam = \lib\db\teams::get(['id' => $this->team_id, 'limit' => 1]);

		if($this->check_sended_request() === false)
		{
			$this->send_request();
		}

		return $this->refresh_page();

	}


	/**
	 * { function_description }
	 */
	public function refresh_page()
	{
		\dash\redirect::pwd();
		return ;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function check_sended_request($_team_id = null)
	{
		if($_team_id === null)
		{
			$_team_id = $this->team_id;
		}

		$get =
		[
			'user_idsender'   => \dash\user::id(),
			'category'        => 4,
			'status'          => ["IN", "('awaiting', 'enable')"],
			'related_id'      => $_team_id,
			'related_foreign' => 'teams',
			'needanswer'      => 1,
			'answer'          => null,
			'limit'           => 1,
		];

		$check_notify = \dash\db\notifications::get($get);

		if($check_notify && is_array($check_notify))
		{
			if(isset($check_notify['status']))
			{
				if(array_key_exists('answer', $check_notify) && !$check_notify['answer'])
				{
					return $check_notify;
				}
			}
		}
		return false;
	}

	/**
	 * Sends a request.
	 */
	public function send_request()
	{

		$meta                      = [];
		$meta['teamCode']         = $this->teamCode;
		$meta['team_id']           = $this->team_id;
		$meta['old_owner']         = \dash\user::id();
		$meta['new_owner']         = $this->user_data['id'];
		// $meta['new_owner_data'] = $this->user_data;
		$meta['new_owner_mobile']  = $this->mobile;
		// $meta['team']           = $this->currentTeam;
		$meta['team_logo']         = $this->currentTeam['logourl'];
		$meta['team_name']         = $this->currentTeam['name'];
		$meta['sender_name']       = \dash\user::login('displayname');
		$meta['sender_mobile']     = \dash\user::login('mobile');
		$meta['sender_logo']       = \dash\user::login('avatar');

		if(intval(\dash\user::id()) === intval($this->user_data['id']))
		{
			\dash\notif::error(T_("You try to move team to yourself!"), 'owner');
			$this->_processor(['force_stop' => true]);
			return false;
		}
		$send_notify =
		[
			'from'            => \dash\user::id(),
			'to'              => $this->user_data['id'],
			'cat'             => 'change_owner',
			'related_foreign' => 'teams',
			'status'		  => 'awaiting',
			'related_id'      => $meta['team_id'],
			'meta'            => json_encode(\dash\safe::safe($meta), JSON_UNESCAPED_UNICODE),
			'needanswer'      => 1,
			'content'         => T_("The :alpha team has filed your ownership transfer request, Do you accept this request?", ['alpha' => $this->currentTeam['name']]),
		];

		$a = \dash\db\notifications::set($send_notify);


		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your request was sended"));
		}
	}
}
?>