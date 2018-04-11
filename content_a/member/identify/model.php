<?php
namespace content_a\member\identify;


class model extends \content_a\member\model
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
			'barcode1'         => \dash\request::post('barcode'),
			'rfid1'            => \dash\request::post('rfid'),
			'qrcode1'          => \dash\request::post('qrcode'),
		];

		return $args;
	}





	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_identify($_args)
	{
		$this->user_id   = \dash\user::id();
		$request         = $this->getPost();
		$member          = \dash\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \dash\url::dir(0);
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>