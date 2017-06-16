<?php
namespace content_admin\main;

class view extends \mvc\view
{
	public function config()
	{
		$this->data->bodyclass = 'fixed unselectable dash';
	}


	/**
	 * find team name in url
	 * tejarak.com/admin/ermile
	 * @return ermile
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function find_team_name_url($_args)
	{
		if(isset($_args->match->url[0]) && $_args->match->url[0])
		{
			$url = $_args->match->url[0];

			if(preg_match("/^team\/([a-zA-Z0-9]+)(.*)$/", $url, $split))
			{
				if(isset($split[1]))
				{
					return $split[1];
				}
			}
		}
	}
}
?>