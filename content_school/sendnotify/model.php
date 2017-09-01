<?php
namespace content_school\sendnotify;
use \lib\utility;
use \lib\debug;

class model extends \content_school\main\model
{
	/**
	 * post data and update or insert sendnotify data
	 */
	public function post_sendnotify($_args)
	{
		$text = utility::post('message-text');
		if(!$text)
		{
			debug::error(T_("Please fill the message box"), 'message-text');
			return false;
		}

		if(mb_strlen($text) > 10000)
		{
			debug::error(T_("Ops! your text is very large"), 'message-text');
			return false;
		}

		$team_code = \lib\router::get_url(0);

		$list = $this->listMember($team_code, 'code', ['pagenation' => false]);
		if($list && is_array($list))
		{
			$user_ids = array_column($list, 'user_id');
			$user_ids = array_map(function($_a){return \lib\utility\shortURL::decode($_a);},$user_ids);
			$notify = new \lib\utility\notifications;
			$notify->find_way($user_ids);
			$insert_notify = [];
			foreach ($list as $key => $value)
			{
				if(isset($value['user_id']) && isset($value['status']) && $value['status'] === 'active')
				{
					$userid = \lib\utility\shortURL::decode($value['user_id']);
					if($userid)
					{
						$insert_notify =
						[
							'to'       => $userid,
							'cat'      => 'public',
							'from'   => $this->login('id'),
							'content'  => $text,
							'telegram' => true,
							'multi'    => true,
						];
						\lib\db\notifications::set($insert_notify);
					}
				}
			}
			\lib\db\notifications::set_multi_record();
		}

		if(debug::$status)
		{
			debug::true(T_("The notification was sended"));
		}
	}
}
?>