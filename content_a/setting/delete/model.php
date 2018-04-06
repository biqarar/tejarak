<?php
namespace content_a\setting\delete;


class model extends \content_a\main\model
{
	/**
	 *
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_delete()
	{
		$code = \dash\url::dir(0);
		$this->user_id = \lib\user::id();
		\lib\utility::set_request_array(['id' => $code]);
		$this->close_team();
		if(\lib\engine\process::status())
		{
			// \lib\notif::direct();
			\lib\redirect::pwd();
		}
	}
}
?>