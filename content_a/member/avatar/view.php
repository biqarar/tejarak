<?php
namespace content_a\member\avatar;

class view
{

	/**
	 * avatar member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view()
	{
		\content_a\member\view::master_config();
		\dash\data::page_title(T_('avatar member!'));
		\dash\data::page_desc(\dash\data::page_title());
	}

}
?>