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
		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('permission :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('permission member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>