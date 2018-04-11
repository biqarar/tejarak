<?php
namespace content_a\member\observer;


class model
{

	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		if(\dash\request::post('remove'))
		{
			\dash\app::variable(['id' => \dash\request::post('remove'), 'related_id' => \dash\request::get('id')]);
			\lib\app\member::delete_parent();
			\dash\redirect::pwd();
			return ;
		}

		$user_id =
		[
			'id'      => \dash\coding::decode(\dash\request::get('member')),
			'team_id' => \dash\coding::decode(\dash\request::get('id')),
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			$parent_request               = [];
			$parent_request['othertitle'] = \dash\request::post('othertitle');
			$parent_request['id']         = \dash\coding::encode($user_id['user_id']);
			$parent_request['title']      = \dash\request::post('title');
			$parent_request['mobile']     = \dash\request::post('parent_mobile');
			$parent_request['related_id'] = \dash\request::get('id');
			\dash\app::variable($parent_request);

			\lib\app\member::add_parent();

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Observer was saved"));

				$t_T =
				[
					'title' => (\dash\request::post('othertitle') && \dash\request::post('title') === 'custom') ? \dash\request::post('othertitle') : T_(ucfirst(\dash\request::post('title'))),
					'name'  => \dash\data::member_displayname(),
					'team'  => \dash\data::currentTeam_name(),
				];

				$message = T_("You are registered as :title of :name in :team", $t_T). '.';
				$message .= "\n\n". T_("Tejarak"). " | ". T_("Modern Approach");
				$message .= "\n". 'tejarak.'. \dash\url::tld(). '/'. \dash\data::currentTeam_short_name();
				$parent_detail = \dash\temp::get('add_parent_detail');

				if(isset($parent_detail['chatid']))
				{
					// user have telegram
					\dash\utility\telegram::sendMessage($parent_detail['chatid'], $message);
				}
				else
				{
					// send by sms
					\dash\utility\sms::send(\dash\request::post('parent_mobile'), $message, ['header' => false, 'footer' => false]);
				}

				\dash\redirect::pwd();
			}
		}
		else
		{
			\dash\notif::error(T_("Invalid user id"));
		}

	}
}
?>