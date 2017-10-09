<?php
namespace content_a\member\permission;

class view extends \content_a\member\view
{

	/**
	 * permission member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_permission($_args)
	{
		$this->data->page['title'] = T_('Special Access');
		$this->data->page['desc']  = T_('You can set some permission to member to do some more activity in Tejarak.');
	}

}
?>