<?php
namespace content_a\setting\general;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{
/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
	{
		$args =
		[
			'name'              => utility::post('name'),
			'website'           => utility::post('website'),
			'privacy'           => utility::post('privacy'),
			'desc'              => utility::post('desc'),
		];

		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_general($_args)
	{
		$code = \lib\router::get_url(0);

		$request       = $this->getPost();
		$this->user_id = $this->login('id');
		$request['id'] = $code;

		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}
}
?>