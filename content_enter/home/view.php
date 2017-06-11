<?php
namespace content_enter\home;

class view extends \content_enter\main\view
{

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