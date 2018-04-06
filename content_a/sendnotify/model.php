<?php
namespace content_a\sendnotify;


class model extends \content_a\main\model
{
	/**
	 * post data and update or insert sendnotify data
	 */
	public function post_sendnotify($_args)
	{
		$text = \lib\request::post('message-text');
		if(!$text)
		{
			\lib\notif::error(T_("Please fill the message box"), 'message-text');
			return false;
		}

		if(mb_strlen($text) > 10000)
		{
			\lib\notif::error(T_("Ops! your text is very large"), 'message-text');
			return false;
		}

		// add sign to footer
		$my_team = $this->getTeamDetail(\dash\url::dir(0));
		$sign    = 'Sended by admin of team';
		if(isset($my_team['name']))
		{
			$sign = T_('Sended by admin of :name', ['name'=> $my_team['name']]);
		}
		$text .= "\n". $sign;


		$team_code = \dash\url::dir(0);

		$list = $this->listMember($team_code, 'code', ['pagenation' => false]);
		if($list && is_array($list))
		{
			$user_ids = array_column($list, 'user_id');
			$user_ids = array_map(function($_a){return \lib\coding::decode($_a);},$user_ids);
			$notify = new \lib\utility\notifications;
			$notify->find_way($user_ids);
			$insert_notify = [];
			foreach ($list as $key => $value)
			{
				if(isset($value['user_id']) && isset($value['status']) && $value['status'] === 'active')
				{
					$userid = \lib\coding::decode($value['user_id']);
					if($userid)
					{
						$insert_notify =
						[
							'to'       => $userid,
							'cat'      => 'public',
							'from'   => \lib\user::id(),
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

		if(\lib\engine\process::status())
		{
			\lib\notif::ok(T_("The notification was sended"));
		}
	}
}
?>