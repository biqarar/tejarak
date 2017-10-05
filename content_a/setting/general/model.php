<?php
namespace content_a\setting\general;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{
	public $user_data;
	public $mobile;
	public $user_id;
	public $team_id;
	public $team_code;
	public $team_detail;


	/**
	 * Loads a last request.
	 */
	public function load_last_request()
	{
		$team_id = \lib\utility\shortURL::decode(\lib\router::get_url(0));
		$load_last_request = $this->check_sended_request($team_id);
		if(isset($load_last_request['user_id']))
		{
			$user_data             = \lib\db\users::get_by_id($load_last_request['user_id']);
			$result                = [];
			$result['mobile']      = (isset($user_data['mobile'])) ? $user_data['mobile'] : null;
			$result['displayname'] = (isset($user_data['displayname'])) ? $user_data['displayname'] : null;
			$result['fileurl']    = (isset($user_data['fileurl'])) ? $user_data['fileurl'] : null;
			$result['status']      = (isset($load_last_request['status'])) ? $load_last_request['status'] : null;
			$result['id']          = (isset($load_last_request['id'])) ? $load_last_request['id'] : null;
			return $result;
		}
		return false;
	}




	/**
	 * Posts an general.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_general($_args)
	{
		if(!$this->login())
		{
			debug::error(T_("Please login to change general"), 'general');
			return $this->refresh_page();
		}

		// the request was sended
		if($load_last_request = $this->load_last_request())
		{
			if($load_last_request['status'] === 'awaiting')
			{
				if(utility::post('send') === 'ok')
				{
					\lib\db\notifications::update(['status' => 'enable'], $load_last_request['id']);
				}
				elseif(utility::post('send') === 'cancel')
				{
					\lib\db\notifications::update(['status' => 'cancel'], $load_last_request['id']);
				}
			}
			elseif($load_last_request['status'] === 'enable')
			{
				if(utility::post('request') === 'cancel')
				{
					\lib\db\notifications::update(['status' => 'cancel'], $load_last_request['id']);
				}
			}
			return $this->refresh_page();
		}


		$new_general = utility::post('general');
		if(!$new_general)
		{
			debug::error(T_("Plese fill the mobile field"), 'general');
			return $this->refresh_page();
		}

		if(!$this->mobile = \lib\utility\filter::mobile($new_general))
		{
			debug::error(T_("Invalid mobile number"), 'general');
			return $this->refresh_page();
		}

		$this->user_data = \lib\db\users::get_by_mobile($this->mobile);
		if(!isset($this->user_data['id']))
		{
			debug::error(T_("User not found"), 'general');
			return $this->refresh_page();
		}

		$this->team_code = \lib\router::get_url(0);
		$this->team_id = \lib\utility\shortURL::decode($this->team_code);
		$this->team_detail = \lib\db\teams::get(['id' => $this->team_id, 'limit' => 1]);

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
		$this->redirector($this->url('full'));
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
			'user_idsender'   => $this->login('id'),
			'category'        => 4,
			'status'          => ["IN", "('awaiting', 'enable')"],
			'related_id'      => $_team_id,
			'related_foreign' => 'teams',
			'needanswer'      => 1,
			'answer'          => null,
			'limit'           => 1,
		];

		$check_notify = \lib\db\notifications::get($get);

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
		$meta['team_code']         = $this->team_code;
		$meta['team_id']           = $this->team_id;
		$meta['old_general']         = $this->login('id');
		$meta['new_general']         = $this->user_data['id'];
		// $meta['new_general_data'] = $this->user_data;
		$meta['new_general_mobile']  = $this->mobile;
		// $meta['team']           = $this->team_detail;
		$meta['team_logo']         = $this->team_detail['logourl'];
		$meta['team_name']         = $this->team_detail['name'];
		$meta['sender_name']       = $this->login('displayname');
		$meta['sender_mobile']     = $this->login('mobile');
		$meta['sender_logo']       = $this->login('fileurl');

		if(intval($this->login('id')) === intval($this->user_data['id']))
		{
			debug::error(T_("You try to move team to yourself!"), 'general');
			$this->_processor(['force_stop' => true]);
			return false;
		}
		$send_notify =
		[
			'from'            => $this->login('id'),
			'to'              => $this->user_data['id'],
			'cat'             => 'change_general',
			'related_foreign' => 'teams',
			'status'		  => 'awaiting',
			'related_id'      => $meta['team_id'],
			'meta'            => json_encode(\lib\utility\safe::safe($meta), JSON_UNESCAPED_UNICODE),
			'needanswer'      => 1,
			'content'         => T_("The :alpha team has filed your generalship transfer request, Do you accept this request?", ['alpha' => $this->team_detail['name']]),
		];

		$a = \lib\db\notifications::set($send_notify);


		if(debug::$status)
		{
			debug::true(T_("Your request was sended"));
		}
	}
}
?>