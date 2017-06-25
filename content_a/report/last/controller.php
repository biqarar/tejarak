<?php
namespace content_a\report\last;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		/**
		 * the router remove first url
		 * we set this on the contetn_a/home/controller
		 * and set on the url manually!!!
		 */
		if(\lib\storage::get_team_code_url() && \lib\storage::get_team_code_url() !== \lib\router::get_url(0))
		{
			\lib\router::set_url(\lib\storage::get_team_code_url(). '/'. \lib\router::get_url());
		}

		$this->get(false, 'last')->ALL("/^([a-zA-Z0-9]+)\/report\/last$/");
	}
}
?>