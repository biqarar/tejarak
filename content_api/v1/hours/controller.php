<?php
namespace content_api\v1\hours;

class controller extends \addons\content_api\home\controller
{

	/**
	 * hours
	 */
	public function _route()
	{
		// get hours list
		$this->get('hoursList')->ALL('v1/hourslist');
		// get 1 hours detail
		$this->get('one_hours')->ALL('v1/hours');
		// set hours group
		// used from @tejarakbot in https://t.me
		$this->post('setTelegramGroup')->ALL('v1/hours/telegram/group');
		// add new hours
		$this->post('hours')->ALL('v1/hours');
		// update old hours
		$this->patch('hours')->ALL('v1/hours');
	}
}
?>