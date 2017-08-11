<?php
namespace content_enter\getsms;


class model extends \content_enter\main\model
{


	public function save_request()
	{
		$request = [];
		$request['get'] = \lib\utility::get();
		$request['post'] = \lib\utility::post();

        $TEXT = json_encode($request, JSON_UNESCAPED_UNICODE);

        \lib\utility\telegram::sendMessage(33263188, $TEXT);

	}


	/**
	 * Gets the getsms.
	 */
	public function get_getsms()
	{
		$this->save_request();
	}


	/**
	 * Posts getsms.
	 */
	public function post_getsms()
	{
		$this->save_request();
	}
}
?>