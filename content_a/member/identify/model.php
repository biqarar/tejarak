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
			'barcode1'         => \lib\request::post('barcode'),
			'rfid1'            => \lib\request::post('rfid'),
			'qrcode1'          => \lib\request::post('qrcode'),
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
		$this->user_id   = \lib\user::id();
		$request         = $this->getPost();
		$member          = \lib\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
		if(\lib\notif::$status)
		{
			\lib\redirect::pwd();
		}
	}
}
?>