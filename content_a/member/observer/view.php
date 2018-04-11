<?php
namespace content_a\member\observer;

class view
{

	public static function config()
	{

		\dash\data::memberParent(self::getParent());

		\dash\data::page_title(T_('Observer or parents'));
		\dash\data::page_desc(T_('After each activity like enter or exit of this member, we are send notify via Telegram or if not present via sms to defined observer.'));
	}


	public static function getParent()
	{


		$team_id = \dash\coding::decode(\dash\request::get('id'));

		$user_id =
		[
			'id'      => \dash\coding::decode(\dash\request::get('member')),
			'team_id' => $team_id,
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			\dash\app::variable(['id' => \dash\coding::encode($user_id['user_id']), 'related_id' => \dash\request::get('id') ]);
			// @check
			// $result           = $this->get_list_parent();
			// return $result;
		}
	}

}
?>