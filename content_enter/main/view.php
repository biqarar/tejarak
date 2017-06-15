<?php
namespace content_enter\main;

class view extends \mvc\view
{
	use _use;
	/**
	 * config
	 */
	public function config()
	{
		$this->include->css    = true;
		$this->include->js     = false;
		$this->data->bodyclass = 'unselectable';
		$this->data->bodyclass .= ' bg'. rand(1, 15);
		// get mobile number to show in mobile input
		$get_mobile = $this->model()->get_enter_session('mobile');

		// if mobile not set but the user was login
		// for example in pass/change page
		// get the user mobile from login.mobile
		if(!$get_mobile && $this->login('mobile'))
		{
			$get_mobile = $this->login('mobile');
		}
		// set mobile in display
		$this->data->get_mobile = $get_mobile;


		// in all page the mobiel input is readonly
		$this->data->mobile_readonly = true;

	}
}
?>