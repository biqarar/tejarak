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
		$this->user_id = $this->login('id');

		$team_id = \lib\utility\shortURL::decode(\lib\url::dir(0));

		$user_id =
		[
			'id'      => \lib\utility\shortURL::decode(\lib\router::get_url(3)),
			'team_id' => $team_id,
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			\lib\utility::set_request_array(['id' => \lib\utility\shortURL::encode($user_id['user_id']), 'related_id' => \lib\url::dir(0) ]);
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
		$this->user_id                = $this->login('id');

		if(\lib\utility::post('remove'))
		{
			\lib\utility::set_request_array(['id' => \lib\utility::post('remove'), 'related_id' => \lib\url::dir(0)]);
			$this->delete_parent();
			$this->redirector(\lib\url::pwd());
			return ;
		}

		$user_id =
		[
			'id'      => \lib\utility\shortURL::decode(\lib\router::get_url(3)),
			'team_id' => \lib\utility\shortURL::decode(\lib\url::dir(0)),
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			$parent_request               = [];
			$parent_request['othertitle'] = \lib\utility::post('othertitle');
			$parent_request['id']         = \lib\utility\shortURL::encode($user_id['user_id']);
			$parent_request['title']      = \lib\utility::post('title');
			$parent_request['mobile']     = \lib\utility::post('parent_mobile');
			$parent_request['related_id'] = \lib\url::dir(0);
			\lib\utility::set_request_array($parent_request);
			$this->add_parent();
			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Observer was saved"));

				$t_T =
				[
					'title' => (\lib\utility::post('othertitle') && \lib\utility::post('title') === 'custom') ? \lib\utility::post('othertitle') : T_(ucfirst(\lib\utility::post('title'))),
					'name'  => $this->view()->data->member['displayname'],
					'team'  => $this->view()->data->current_team['name'],
				];

				$message = T_("You are registered as :title of :name in :team", $t_T). '.';
				$message .= "\n\n". T_("Tejarak"). " | ". T_("Modern Approach");
				$message .= "\n". 'tejarak.'. \lib\url::tld(). '/'. $this->view()->data->current_team['short_name'];
				$parent_detail = \lib\temp::get('add_parent_detail');

				if(isset($parent_detail['chatid']))
				{
					// user have telegram
					\lib\utility\telegram::sendMessage($parent_detail['chatid'], $message);
				}
				else
				{
					// send by sms
					\lib\utility\sms::send(\lib\utility::post('parent_mobile'), $message, ['header' => false, 'footer' => false]);
				}

				$this->redirector(\lib\url::pwd());
			}
		}
		else
		{
			\lib\debug::error(T_("Invalid user id"));
		}

	}
}
?>