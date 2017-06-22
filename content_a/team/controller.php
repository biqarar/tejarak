<?php
namespace content_a\team;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();
		if($url === 'team')
		{
			// add team
			$this->get(false, 'add')->ALL('team');
			$this->post('add')->ALL('team');
		}
		elseif(preg_match("/^[a-zA-Z0-9]+$/", $url) && substr($url, 0, 4) !== 'team')
		{
			// route url like:
			// a/2kf
			\lib\router::set_controller('content_a\\member\\controller');
			return;
		}
		elseif(preg_match("/^team\/[a-zA-Z0-9]+\/member$/", $url))
		{
			// route url like:
			// a/team/2kf/member
			\lib\router::set_controller('content_a\\member\\controller');
			return;
		}
		elseif(preg_match("/^team\/[a-zA-Z0-9]+\/member\=[a-zA-Z0-9]+$/", $url))
		{
			// route url like:
			// a/team/2kf/member=123
			\lib\router::set_controller('content_a\\member\\controller');
			return;
		}
		else
		{
			// the url is team/ermile we remove team/ from first of url to get the 'ermile' [team brand]
			$name = str_replace('team/', '', $url);
			// check the team exist or no and this user is the boss ot this team
			// this function in content_admi/main/model
			$id = \lib\utility\shortURL::decode($name);

			if($id && $this->model()->is_exist_team_id($id))
			{
				$this->get(false, 'edit')->ALL("team/$name");
				$this->post('edit')->ALL("team/$name");
			}
		}
	}
}
?>