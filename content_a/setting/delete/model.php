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
		$this->user_id = \dash\user::id();
		\dash\app::variable(['id' => $code]);
		$this->close_team();
		if(\dash\engine\process::status())
		{
			// \dash\notif::direct();
			\dash\redirect::pwd();
		}
	}
}
?>