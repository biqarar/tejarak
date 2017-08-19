<?php
namespace content_a\billing\detail;
use \lib\utility;
use \lib\debug;
use \lib\utility\payment;

class model extends \mvc\model
{

	/**
	 * get detail data to show
	 */
	public function get_detail($_args)
	{
		if(!$this->login())
		{
			return false;
		}

		return $this->useage();
	}



	/**
	 * use useage
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function useage()
	{

		if(isset($_SESSION['useage_team_detail']) && isset($_SESSION['useage_team_detail_time']))
		{
			if(time() - strtotime($_SESSION['useage_team_detail_time']) > (60*60))
			{
				$_SESSION['useage_team_detail'] = $this->run_useage();
				$_SESSION['useage_team_detail_time'] = date("Y-m-d H:i:s");
			}
		}
		else
		{
			$_SESSION['useage_team_detail'] = $this->run_useage();
			$_SESSION['useage_team_detail_time'] = date("Y-m-d H:i:s");
		}

		return $_SESSION['useage_team_detail'];
	}


	/**
	 * { function_description }
	 */
	public function run_useage()
	{
		if(!$this->login())
		{
			return false;
		}

		$user_id = $this->login('id');

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
					$all_creator_team[$key]['useage'] = $calc->calc();
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