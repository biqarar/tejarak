<?php
namespace content_a\member\observer;
use \lib\utility;
use \lib\debug;

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

		$user_id =
		[
			'id'      => utility\shortURL::decode(\lib\router::get_url(3)),
			'team_id' => utility\shortURL::decode(\lib\router::get_url(0)),
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			utility::set_request_array(['id' => \lib\utility\shortURL::encode($user_id['user_id'])]);
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

		if(utility::post('remove'))
		{
			utility::set_request_array(['id' => utility::post('remove')]);
			$this->delete_parent();
			$this->redirector($this->url('full'));
			return ;


		}

		$user_id =
		[
			'id'      => utility\shortURL::decode(\lib\router::get_url(3)),
			'team_id' => utility\shortURL::decode(\lib\router::get_url(0)),
			'limit'   => 1,
		];
		$user_id = \lib\db\userteams::get($user_id);
		if(isset($user_id['user_id']))
		{
			$parent_request               = [];
			$parent_request['othertitle'] = utility::post('othertitle');
			$parent_request['id']         = utility\shortURL::encode($user_id['user_id']);
			$parent_request['title']      = utility::post('title');
			$parent_request['mobile']     = utility::post('parent_mobile');
			utility::set_request_array($parent_request);
			$this->add_parent();
			if(debug::$status)
			{
				debug::true(T_("Observer was saved"));
				$this->redirector($this->url('full'));
			}
		}
		else
		{
			debug::error(T_("Invalid user id"));
		}

	}
}
?>