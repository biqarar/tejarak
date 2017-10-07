<?php
namespace content_a\member\personal;

class view extends \content_a\member\view
{

	/**
	 * personal member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_personal($_args)
	{
		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('personal :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('personal member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>