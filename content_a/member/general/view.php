<?php
namespace content_a\member\general;

class view extends \content_a\member\view
{

	/**
	 * general member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_general($_args)
	{
		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('general :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('general member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>