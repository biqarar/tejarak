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
		$memberName = '';
		if(isset($this->data->member['displayname']))
		{
			$memberName = $this->data->member['displayname'];
		}

		$this->data->page['title'] = T_('General setting | :name', ['name' => $memberName]);
		$this->data->page['desc']  = T_('Manage general setting of member like name and position, you can change another setting by choose another type of setting.');

	}

}
?>