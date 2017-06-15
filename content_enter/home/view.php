<?php
namespace content_enter\home;

class view extends \content_enter\main\view
{
	/**
	 * config view
	 */
	public function config()
	{
		// read parent config to fill the mobile input and other thing
		parent::config();
		// just on this page the mobile is not read only
		$this->data->mobile_readonly = false;
	}


	/**
	 * view enter
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_enter($_args)
	{
		$mobile = \lib\utility::get('mobile');
		if($mobile)
		{
			$this->data->get_mobile = \lib\utility\filter::mobile($mobile);
		}
	}
}
?>