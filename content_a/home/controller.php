<?php
namespace content_a\home;

class controller
{
	/**
	 * rout
	 */
	public static function routing()
	{
		// check if the user is gateway redirect to hours page
		if(!\dash\user::login('mobile') && \dash\user::login('parent') && \dash\user::login('username') && \dash\user::login('password'))
		{
			$check_is_gateway = \lib\db\userteams::get(['user_id' => \dash\user::id(), 'rule' => 'gateway', 'limit'=> 1]);
			if(isset($check_is_gateway['team_id']))
			{
				$shortname = \lib\db\teams::get_by_id($check_is_gateway['team_id']);
				if(isset($shortname['shortname']))
				{
					$new_url = \dash\url::base(). '/'. $shortname['shortname'];
					\dash\redirect::to($new_url);
					return;
				}
			}
		}
	}
}
?>