<?php
namespace content_a\member\observer;


class model extends \content_a\member\model
{

	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getParent()
	{
		$this->user_id = \dash\user::id();

		$team_id = \dash\coding::decode(\dash\url::dir(0));

		$user_id =
		[
			'id'      => \dash\coding::decode(\dash\url::dir(3)),
			'team_id' => $team_id,
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			\dash\app::variable(['id' => \dash\coding::encode($user_id['user_id']), 'related_id' => \dash\url::dir(0) ]);
			$result           = $this->get_list_parent();
			return $result;
		}
	}





	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_observer($_args)
	{
		$this->user_id                = \dash\user::id();

		if(\dash\request::post('remove'))
		{
			\dash\app::variable(['id' => \dash\request::post('remove'), 'related_id' => \dash\url::dir(0)]);
			$this->delete_parent();
			\dash\redirect::pwd();
			return ;
		}

		$user_id =
		[
			'id'      => \dash\coding::decode(\dash\url::dir(3)),
			'team_id' => \dash\coding::decode(\dash\url::dir(0)),
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
			$parent_request['related_id'] = \dash\url::dir(0);
			\dash\app::variable($parent_request);
			$this->add_parent();
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Observer was saved"));

				$t_T =
				[
					'title' => (\dash\request::post('othertitle') && \dash\request::post('title') === 'custom') ? \dash\request::post('othertitle') : T_(ucfirst(\dash\request::post('title'))),
					'name'  => $this->view()->data->member['displayname'],
					'team'  => $this->view()->data->currentTeam['name'],
				];

				$message = T_("You are registered as :title of :name in :team", $t_T). '.';
				$message .= "\n\n". T_("Tejarak"). " | ". T_("Modern Approach");
				$message .= "\n". 'tejarak.'. \dash\url::tld(). '/'. $this->view()->data->currentTeam['short_name'];
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