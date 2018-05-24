<?php
namespace content_a\request\add;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_('Add new request'));
		\dash\data::page_desc(T_('You can add new request of time and after confirm of team admin, this time is added to your hours.'));
		\content_a\report\view::showAllUser();

		if(\dash\request::get('user'))
		{
			$user             = \dash\request::get('user');
			$all_user = \dash\data::allUserList();
			if(isset($all_user[$user]))
			{
				\dash\data::requestList([$all_user[$user]]);

				if(isset($all_user[$user]['24h']) && $all_user[$user]['24h'])
				{
					\dash\data::is24h(true);
				}
			}

			\dash\data::teamCode(\dash\request::get('id'));
		}
	}
}
?>