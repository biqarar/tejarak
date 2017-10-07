<?php
namespace content_a\member\identify;

class view extends \content_a\member\view
{

	/**
	 * identify member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_identify($_args)
	{
		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('identify :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('identify member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>