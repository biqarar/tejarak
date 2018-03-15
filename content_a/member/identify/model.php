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
			'barcode1'         => \lib\utility::post('barcode'),
			'rfid1'            => \lib\utility::post('rfid'),
			'qrcode1'          => \lib\utility::post('qrcode'),
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
		$this->user_id   = $this->login('id');
		$request         = $this->getPost();
		$member          = \lib\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
		if(\lib\debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>