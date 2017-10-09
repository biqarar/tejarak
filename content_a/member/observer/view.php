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

		$this->data->page['title'] = T_('Observer or parents');
		$this->data->page['desc']  = T_('After each activity like enter or exit of this member, we are send notify via Telegram or if not present via sms to defined observer.');
	}
}
?>