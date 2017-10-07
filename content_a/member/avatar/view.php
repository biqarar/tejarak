<?php
namespace content_a\member\avatar;

class view extends \content_a\member\view
{

	/**
	 * avatar member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_avatar($_args)
	{
		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('avatar :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('avatar member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>