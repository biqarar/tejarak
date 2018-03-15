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

		$this->data->edit_mode     = true;
		$url                       = \lib\url::directory();
		$team                      = \lib\url::dir(0);
		$member                    = \lib\router::get_url(3);

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