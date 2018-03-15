<?php
namespace content_a\report;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{
		//

		/**
		 * the router remove first url
		 * we set this on the contetn_a/home/controller
		 * and set on the url manually!!!
		 */
		if(\lib\temp::get('team_code_url') && \lib\temp::get('team_code_url') !== \lib\router::get_url(0))
		{
			\lib\router::set_url(\lib\temp::get('team_code_url'). '/'. \lib\url::directory());
		}

		$url = \lib\url::directory();

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
							case 'settings':
								if(!\lib\temp::get('is_admin'))
								{
									\lib\error::access();
								}
							case 'last':
							case 'year':
							case 'month':
							case 'period':

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
						// the main report page
						// list of reports link
						// like this; http://tejarak.com/a/2kf/report
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