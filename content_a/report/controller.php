<?php
namespace content_a\report;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
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

		$url = \lib\router::get_url();

		$split = explode('/', $url);

		// $team = isset($split[0]) ? $split[0] : null;
		if(isset($split[1]))
		{
			switch ($split[1])
			{
				case 'report':
					if(isset($split[2]))
					{
						switch ($split[2])
						{
							case 'last':
							case 'daily':
							case 'u':
							case 'sum':
								\lib\router::set_controller("content_a\\report\\$split[2]\\controller");
								return;
								break;

							default:
								\lib\error::page();
								break;
						}
					}
					else
					{
						$this->get()->ALL($url);
					}
					break;
				default:
					\lib\error::page();
					break;
			}
		}
	}
}
?>