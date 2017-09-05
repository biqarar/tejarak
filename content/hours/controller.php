<?php
namespace content\hours;

class controller extends \content\main\controller
{
	/**
	 * route hous page
	 */
	public function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();
		// this module name is hours
		// the house url can not be route
		if($url === 'hours')
		{
			\lib\error::page();
		}
		$list_member = $this->model()->list_member(['shortname' => $url]);

		if($list_member)
		{
			\lib\storage::set_list_member($list_member);
			//check valid url and exits team
			$this->get(false, 'show')->ALL($url);
			$this->post('hours')->ALL($url);
		}
		elseif(\lib\storage::get_team_exist())
		{
			\lib\error::access(T_("Access denied to load this team data"));
		}
	}
}
?>