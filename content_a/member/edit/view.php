<?php
namespace content_a\member\edit;

class view extends \content_a\member\view
{

	/**
	 * edit member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{

		$this->data->editMode     = true;
		$url                       = \dash\url::directory();
		$team                      = \dash\request::get('id');
		$member                    = \dash\url::dir(3);

		$member                    = $this->model()->edit($team, $member);

		$this->data->member        = $member;

		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('Edit :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('Edit member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>