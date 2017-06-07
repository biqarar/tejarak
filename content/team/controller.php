<?php
namespace content\team;

class controller extends \content\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		if($this->is_exist_team($url))
		{
			$this->get(false, 'dashboard')->ALL("$url");
		}

	}
}
?>