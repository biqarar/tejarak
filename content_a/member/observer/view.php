<?php
namespace content_a\member\observer;

class view extends \content_a\member\view
{

	/**
	 * observer member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_observer($_args)
	{

		$this->data->member_parent = $this->model()->getParent();

		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('observer :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('observer member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>