<?php
namespace content_a\member\identify;


class model
{

	public static function getPost()
	{
		$args =
		[
			'barcode1'         => \dash\request::post('barcode'),
			'rfid1'            => \dash\request::post('rfid'),
			'qrcode1'          => \dash\request::post('qrcode'),
		];
		return $args;
	}


	public static function post()
	{

		$request         = self::getPost();
		$member          = \dash\request::get('member');
		$request['id']   = $member;
		$request['team'] = \dash\request::get('id');
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		\lib\app\member::add_member(['method' => 'patch']);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>