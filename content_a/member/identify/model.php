<?php
namespace content_a\member\identify;
use \lib\utility;
use \lib\debug;

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
			'barcode1'         => utility::post('barcode'),
			'rfid1'            => utility::post('rfid'),
			'qrcode1'          => utility::post('qrcode'),
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
		$member          = \lib\router::get_url(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\url::dir(0);
		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
		if(debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>