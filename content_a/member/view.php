<?php
namespace content_a\member;

class view
{

	/**
	 * get list of member on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function config()
	{
		self::master_config();

		$team                    = \dash\request::get('id');
		$request                 = [];
		$request['id']           = $team;
		$member_list             = self::listMember($request);


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

		\dash\data::listMember($member_list);

		\dash\data::page_title(T_('Member of :name', ['name'=> \dash\data::currentTeam_name()]));
		\dash\data::page_desc(T_('Quick view to team members and add or edit detail of members'));

	}


	public static function master_config()
	{
		$team                      = \dash\request::get('id');
		$member                    = \dash\request::get('member');

		$creator_id = \dash\data::currentTeam_creator();
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
					\dash\temp::set('changeCreator', true);
				}
			}

			if(isset($get_user_id['rule']) && $get_user_id['rule'] === 'admin')
			{
				\dash\temp::set('changeAdmin', true);
			}
		}


		\dash\data::changeCreator(\dash\temp::get('changeCreator'));
		\dash\data::changeAdmin(\dash\temp::get('changeAdmin'));
		\dash\data::isAdmin(\dash\temp::get('isAdmin'));
		\dash\data::isCreator(\dash\temp::get('isCreator'));

		if($member)
		{
			$member = self::edit($team, $member);
			\dash\data::member($member);
		}
	}


		/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function listMember($_args)
	{
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		\dash\app::variable($request);
		$result =  \lib\app\member::get_list_member();
		return $result;
	}


	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function edit($_team, $_member)
	{
		$request          = [];
		$request['team']  = $_team;
		$request['id']    = $_member;
		\dash\app::variable($request);
		$result           =  \lib\app\member::get_member();
		return $result;
	}
}
?>