<?php
namespace content_admin\main;

class model extends \mvc\model
{
	use \content_api\v1\branch\tools\get;
	use \content_api\v1\branch\tools\add;

	use \content_api\v1\team\tools\add;
	use \content_api\v1\team\tools\get;
	use \content_api\v1\team\tools\delete;

	use \content_api\v1\staff\tools\add;
	use \content_api\v1\staff\tools\get;

	use \content_api\v1\getway\tools\get;
	use \content_api\v1\getway\tools\add;


	/**
	 * Gets the addbranch.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeam($_args)
	{
		$this->user_id = $this->login('id');
		$team = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		\lib\utility::set_request_array(['team' => $team]);
		return $this->get_team();
	}
}
?>