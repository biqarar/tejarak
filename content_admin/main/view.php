<?php
namespace content_admin\main;

class view extends \mvc\view
{

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
			$url = str_replace('team/', '', $url);
			return $url;
		}
		return null;
	}


	/**
	 * Pushes a state.
	 */
	public function pushState()
	{

	}
}
?>