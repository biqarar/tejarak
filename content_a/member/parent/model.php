<?php
namespace content_a\member\parent;


class model extends \content_a\member\model
{

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function listMember($_args)
	{
		$this->user_id  = \dash\user::id();


		$team_id        = \dash\coding::decode(\dash\request::get('id'));
		$get_userparent = ['related_id' => $team_id, 'status' => 'enable'];
		$userparent     = \dash\db\userparents::load_parent($get_userparent);



		$request        = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		\dash\app::variable($request);
		$result =  $this->get_listMember();

		if(!is_array($result))
		{
			return false;
		}

		$user_ids      = array_column($result, 'user_id');
		$user_ids      = array_map(function($_a){return \dash\coding::decode($_a);}, $user_ids);
		$result        = array_combine($user_ids, $result);

		foreach ($userparent as $key => $value)
		{
			if(array_key_exists($value['user_id'], $result))
			{
				$result[$value['user_id']]['parent'][] = $value;
			}
		}
		// var_dump($result);exit();
		return $result;
	}
}
?>