<?php
namespace content_a\gateway\add;

class view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function view_add()
	{
		\dash\data::page_title(T_('Add new gateway'));
		\dash\data::page_desc(T_('Allow to add specefic type of user that only allow to set enter and exit without more permission.'));
	}
}
?>