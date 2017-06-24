<?php
namespace content_a\main;

trait _use
{
	// API OPTIONS
	use \content_api\v1\home\tools\options;

	// API HOURS
	use \content_api\v1\hours\tools\add;

	// API TEAM
	use \content_api\v1\team\tools\add;
	use \content_api\v1\team\tools\get;
	use \content_api\v1\team\tools\close;

	// API MEMBER
	use \content_api\v1\member\tools\add;
	use \content_api\v1\member\tools\get;

	// API GETWAY
	use \content_api\v1\getway\tools\get;
	use \content_api\v1\getway\tools\add;

	// API FILE
	use \content_api\v1\file\tools\get;
	use \content_api\v1\file\tools\link;

	// API REPORT
	use \content_api\v1\report\tools\get;


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeamDetail($_team)
	{
		$request         = [];
		$this->user_id   = $this->login('id');
		$request['id'] = $_team;
		\lib\utility::set_request_array($request);
		$result = $this->get_team();
		return $result;
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeamDetailShortname($_shortname)
	{
		$request             = [];
		$this->user_id       = $this->login('id');
		$request['shortname'] = $_shortname;
		\lib\utility::set_request_array($request);
		$result = $this->get_team();
		return $result;
	}
}
?>