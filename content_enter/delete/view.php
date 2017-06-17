<?php
namespace content_enter\delete;

class view extends \content_enter\main\view
{

	/**
	 * view enter
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function config()
	{
		parent::config();

		if(self::get_enter_session('request_delete_msg'))
		{
			$this->data->get_why = self::get_enter_session('request_delete_msg');
		}
	}
}
?>