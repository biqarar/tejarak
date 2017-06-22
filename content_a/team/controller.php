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

		// add team
		$this->get(false, 'add')->ALL('team');
		$this->post('add')->ALL('team');


		// route url like:
		// a/ermile/member
		// a/ermile/member=123
		// a/ermile/branch=sarshomar/member
		// a/ermile/branch=sarshomar/member=123
		if(
			preg_match("/^team\/([a-zA-Z0-9]+)\/branch\=([a-zA-Z0-9]+)\/member(|\=([a-zA-Z0-9]+))$/", $url) ||
			preg_match("/^team\/([a-zA-Z0-9]+)\/member(|\=([a-zA-Z0-9]+))$/", $url)
		  )
		{
			\lib\router::set_controller('content_a\member\controller');
			return;
		}

		// the url like this a/ermile/branch
		if(preg_match("/^team\/([a-zA-Z0-9]+)\/branch(|\=([a-zA-Z0-9]+))$/", $url))
		{
			\lib\router::set_controller('content_a\branch\controller');
			return;
		}

		// the url is team/ermile we remove team/ from first of url to get the 'ermile' [team brand]
		$name = str_replace('team/', '', $url);
		// check the team exist or no and this user is the boss ot this team
		// this function in content_admi/main/model
		if($this->model()->is_exist_team_id(\lib\utility\shortURL::decode($name)))
		{
			$this->get(false, 'edit')->ALL("team/$name");
			$this->post('edit')->ALL("team/$name");
		}
	}
}
?>