<?php
namespace content_a\member;

class view extends \content_a\main\view
{

	public function config()
	{
		$team                      = \dash\url::dir(0);
		$member                    = \dash\url::dir(3);

		if(isset($this->data->currentTeam['creator']))
		{
			$creator_id = $this->data->currentTeam['creator'];
			$creator_id = \dash\coding::decode($creator_id);

			$userteam_id = $member;
			$userteam_id = \dash\coding::decode($userteam_id);

			if($userteam_id)
			{
				$get_user_id = \lib\db\userteams::get(['id' => $userteam_id, 'limit' => 1]);

				if(isset($get_user_id['user_id']))
				{
					if(intval($get_user_id['user_id']) === intval($creator_id))
					{
						\dash\temp::set('change_creator', true);
					}
				}

				if(isset($get_user_id['rule']) && $get_user_id['rule'] === 'admin')
				{
					\dash\temp::set('change_admin', true);
				}
			}
		}

		$this->data->change_creator = \dash\temp::get('change_creator');
		$this->data->change_admin   = \dash\temp::get('change_admin');
		$this->data->isAdmin       = \dash\temp::get('isAdmin');
		$this->data->isCreator     = \dash\temp::get('isCreator');

		if($member)
		{
			$member                    = $this->model()->edit($team, $member);
			$this->data->member        = $member;
		}
	}


	/**
	 * get list of member on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$team                    = \dash\url::dir(0);
		$request                 = [];
		$request['id']           = $team;
		$member_list             = $this->model()->list_member($request);


		if(is_array($member_list))
		{
			$ids          = array_column($member_list, 'id');
			$member_list    = array_combine($ids, $member_list);
			$ids          = array_map(function($_a){return \dash\coding::decode($_a);}, $ids);
			$member_session_list_time = \dash\session::get('member_list_detail_time');
			if(time() - intval($member_session_list_time) > 60)
			{
				$static_count = \lib\db\userteams::count_detail($ids, true);
				\dash\session::set('member_list_detail', $static_count);
				\dash\session::set('member_list_detail_time', time());
			}
			else
			{
				$static_count = \dash\session::get('member_list_detail');
			}

			foreach ($member_list as $key => $value)
			{
				if(array_key_exists($key, $static_count))
				{
					$member_list[$key]['stats'] = $static_count[$key];
				}
			}
		}

		$this->data->list_member = $member_list;

		if(isset($this->data->currentTeam['name']))
		{
			$this->data->page['title'] = T_('Member of :name', ['name'=> $this->data->currentTeam['name']]);
			$this->data->page['desc']  = T_('Quick view to team members and add or edit detail of members');
		}
	}
}
?>