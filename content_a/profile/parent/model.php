<?php
namespace content_a\profile\parent;


class model
{
	public static $get_data;
	public static $parent_id;

	/**
	 * get list parent
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function list_parent()
	{
		\dash\app::variable(['id' => \dash\coding::encode(\dash\user::id())]);
		$result = \dash\app\iparent::get_list_parent();
		return $result;
	}


	/**
	 * cancel request
	 */
	public static function cancel_request()
	{
		\dash\app::variable(['id' => \dash\request::post('cancel')]);
		\dash\app\iparent::parent_cancel_request();
		self::redirector_refresh();
	}


	/**
	 * redirect to full
	 */
	public static function redirector_refresh()
	{
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
			return;
		}
		return;
	}


	/**
	 * Removes a parent.
	 */
	public static function remove_parent()
	{
		\dash\app::variable(['id' => \dash\request::post('remove')]);
		\dash\app\iparent::delete_parent();
		self::redirector_refresh();
	}


	/**
	 * Posts a setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post_parent($_args)
	{

		$request               = [];

		$request['othertitle'] = \dash\request::post('othertitle');
		$request['title']      = \dash\request::post('title');
		$request['mobile']     = \dash\request::post('mobile');
		$request['id']         = \dash\coding::encode($this->user_id);

		\dash\app::variable($request);

		if(\dash\request::post('cancel') && \dash\coding::is(\dash\request::post('cancel')))
		{
			self::cancel_request();
			return ;
		}

		if(\dash\request::post('remove') && \dash\coding::is(\dash\request::post('remove')))
		{
			self::remove_parent();
			return ;
		}

		\dash\app\iparent::add_parent();
		self::redirector_refresh();
	}
}
?>