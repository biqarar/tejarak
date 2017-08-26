<?php
namespace content_a\profile\parent;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{
	public $get_data;
	public $parent_id;


	public function list_parent()
	{
		$result = [];
		$get_notify =
		[
			'user_idsender'   => $this->login('id'),
			'category'        => 9,
			'status'          => 'enable',
			'related_id'      => $this->login('id'),
			'related_foreign' => 'users',
			'needanswer'      => 1,
			'answer'          => null,
		];

		$notify_list = \lib\db\notifications::get($get_notify);
		if($notify_list && is_array($notify_list))
		{
			$notify_list = \lib\utility\filter::meta_decode($notify_list);
			foreach ($notify_list as $key => $value)
			{
				$temp                = [];

				$temp['msg']         = T_("Waiting to user accept this request");
				$temp['notify']      = true;

				$temp['id']          = isset($value['id'])? $value['id'] : null;

				$temp['file_url']    = isset($value['meta']['parent_file_url'])? $value['meta']['parent_file_url'] : null;
				$temp['mobile']      = isset($value['meta']['parent_mobile'])? $value['meta']['parent_mobile'] : null;
				$temp['displayname'] = isset($value['meta']['parent_displayname'])? $value['meta']['parent_displayname'] : null;
				$temp['title']       = isset($value['meta']['title'])? $value['meta']['title'] : null;
				$temp['othertitle']  = isset($value['meta']['othertitle'])? $value['meta']['othertitle'] : null;

				if($temp['title'] === 'custom' && $temp['othertitle'])
				{
					$temp['title'] = $temp['othertitle'];
					unset($temp['othertitle']);
				}

				$result[] = $temp;
			}
		}

		$user_parent_resutl = \lib\db\userparents::load_parent(['user_id' => $this->login('id'), 'status' => 'enable']);
		if(is_array($user_parent_resutl))
		{
			foreach ($user_parent_resutl as $key => $value)
			{
				array_push($result, $value);
			}
		}

		return $result;
	}

	public function cancel_request()
	{
		$notify_id = utility::post('cancel');
		$notify_id = \lib\utility\shortURL::decode($notify_id);
		if(!$notify_id)
		{
			debug::error(T_("Invalid request id"));
			return false;
		}


		$get_notify =
		[
			'id'              => $notify_id,
			'user_idsender'   => $this->login('id'),
			'category'        => 9,
			'status'          => 'enable',
			'related_id'      => $this->login('id'),
			'related_foreign' => 'users',
			'needanswer'      => 1,
			'answer'          => null,
			'limit'           => 1,
		];

		$check_ok = \lib\db\notifications::get($get_notify);
		if(!$check_ok)
		{
			debug::error(T_("Invalid request data"));
			return false;
		}

		\lib\db\notifications::update(['status' => 'cancel'], $notify_id);
		if(debug::$status)
		{
			debug::true(T_("Your request canceled"));
		}

	}

	public function redirector_refresh()
	{
		if(debug::$status)
		{
			$this->redirector($this->url('full'));
			return;
		}
		return;
	}


	public function remove_parent()
	{
		$userparents_id = utility::post('remove');
		$userparents_id = \lib\utility\shortURL::decode($userparents_id);
		if(!$userparents_id)
		{
			debug::error(T_("Invalid remove data"));
			return false;
		}

		$get =
		[
			'id'      => $userparents_id,
			'user_id' => $this->login('id'),
			'limit'   => 1,
		];

		$check = \lib\db\userparents::get($get);
		if(!isset($check['id']))
		{
			debug::error(T_("Invalid remove details"));
			return false;
		}

		\lib\db\userparents::update(['status' => 'deleted'], $userparents_id);
		if(debug::$status)
		{
			debug::true(T_("Parent removed"));
		}
	}

	/**
	 * Posts a setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_parent($_args)
	{

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input'   => utility::post(),
				'session' => $_SESSION,
			],
		];


		if(!$this->login())
		{
			debug::error(T_("Please login to continue"));
			return false;
		}


		if(utility::post('cancel') && \lib\utility\shortURL::is(utility::post('cancel')))
		{
			$this->cancel_request();
			return $this->redirector_refresh();
		}


		if(utility::post('remove') && \lib\utility\shortURL::is(utility::post('remove')))
		{
			$this->remove_parent();
			return $this->redirector_refresh();
		}

		$parent_id = null;

		$mobile = utility::post('mobile');
		if(!$mobile)
		{
			debug::error(T_("Please set the parent mobile"), 'mobile');
			return false;
		}

		$mobile = \lib\utility\filter::mobile($mobile);

		if(!$mobile)
		{
			debug::error(T_("Invalid mobile number"), 'mobile');
			return false;
		}

		if(!utility::post('title'))
		{
			debug::error(T_("Please select one title"));
			return false;
		}

		$this->get_data = $get_data = \lib\db\users::get_by_mobile($mobile);
		if(!isset($get_data['id']))
		{
			$parent_id = \lib\db\users::signup_quice(['user_mobile' => $mobile]);
		}
		else
		{
			$parent_id = $get_data['id'];
		}

		$this->parent_id = $parent_id;

		if(intval($parent_id) === intval($this->login('id')))
		{
			debug::error(T_("You can not set parent yourself"));
			return false;
		}
		$titles =
		[
			'father',
			'mother',
			'sister',
			'brother',
			'grandfather',
			'grandmother',
			'aunt',
			'husband',
			'uncle',
			'boy',
			'girl',
			'spouse',
			'stepmother',
			'stepfather',
			'neighbor',
			'teacher',
			'friend',
			'boss',
			'supervisor',
			'child',
			'grandson',
			'custom',
		];

		if(!in_array(utility::post('title'), $titles))
		{
			debug::error(T_("Invalid title"));
			return false;
		}

		if(utility::post('title') === 'custom' && !utility::post('othertitle'))
		{
			debug::error(T_("Plase set the other title field"));
			return false;
		}

		if(utility::post('othertitle') && mb_strlen(utility::post('othertitle')) > 50)
		{
			debug::error(T_("You must set other title less than 50 character"));
			return false;
		}

		if($this->check_duplicate_request())
		{
			debug::error(T_("Your request was sended to user, wait for answer user"));
			return ;
		}

		$meta                       = [];
		$meta['user_id']            = $this->login('id');
		$meta['user_displayname']   = $this->login('displayname');
		$meta['user_file_url']      = $this->login('file_url');

		$meta['parent_id']          = isset($get_data['id']) ? $get_data['id'] : null;
		$meta['parent_mobile']      = isset($get_data['user_mobile']) ? $get_data['user_mobile'] : null;
		$meta['parent_displayname'] = isset($get_data['user_displayname']) ? $get_data['user_displayname'] : null;
		$meta['parent_file_url']    = isset($get_data['user_file_url']) ? $get_data['user_file_url'] : null;
		$meta['title']              = utility::post('title');
		$meta['othertitle']         = utility::post('othertitle');

		$send_notify =
		[
			'from'            => $this->login('id'),
			'to'              => $parent_id,
			'cat'             => 'set_parent',
			'related_foreign' => 'users',
			'status'		  => 'enable',
			'related_id'      => $this->login("id"),
			'meta'            => json_encode(\lib\utility\safe::safe($meta), JSON_UNESCAPED_UNICODE),
			'needanswer'      => 1,
			'content'         => T_("Are you :title of this user?", ['title' => T_(utility::post('title'))]),
		];

		$a = \lib\db\notifications::set($send_notify);

		if(debug::$status)
		{
			debug::true(T_("Your request was sended"));
		}
		$this->redirector_refresh();

	}


	/**
	 * { function_description }
	 */
	public function check_duplicate_request()
	{
		$get =
		[
			'user_idsender'   => $this->login('id'),
			'user_id'         => $this->parent_id,
			'category'        => 9,
			'status'          => 'enable',
			'related_id'      => $this->login('id'),
			'related_foreign' => 'users',
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
}
?>