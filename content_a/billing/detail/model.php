<?php
namespace content_a\billing\detail;


class model extends \mvc\model
{

	/**
	 * get detail data to show
	 */
	public function get_detail($_args)
	{
		if(!\lib\user::login())
		{
			return false;
		}

		return $this->usage();
	}



	/**
	 * use usage
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function usage()
	{

		if(isset($_SESSION['usage_team_detail']) && isset($_SESSION['usage_team_detail_time']))
		{
			if(time() - strtotime($_SESSION['usage_team_detail_time']) > (60*60))
			{
				$_SESSION['usage_team_detail'] = $this->run_usage();
				$_SESSION['usage_team_detail_time'] = date("Y-m-d H:i:s");
			}
		}
		else
		{
			$_SESSION['usage_team_detail'] = $this->run_usage();
			$_SESSION['usage_team_detail_time'] = date("Y-m-d H:i:s");
		}

		return $_SESSION['usage_team_detail'];
	}


	/**
	 * { function_description }
	 */
	public function run_usage()
	{
		if(!\lib\user::login())
		{
			return false;
		}

		$user_id = \lib\user::id();

		$all_creator_team = \lib\db\teams::get(['creator' => $user_id]);

		if(is_array($all_creator_team))
		{
			foreach ($all_creator_team as $key => $value)
			{
				if(isset($value['id']))
				{
					$calc = new \lib\utility\calc($value['id']);
					$calc->save(false);
					$calc->notify(false);
					$calc->type('calc');
					$all_creator_team[$key]['usage'] = $calc->calc();
					$all_creator_team[$key]['active_member'] = $calc->get_active_member();
					$all_creator_team[$key]['active_time'] = $calc->get_active_time();
				}
			}
		}
		return $all_creator_team;
	}

	/**
	 * post data and update or insert detail data
	 */
	public function post_detail()
	{

	}
}
?>