<?php
namespace lib\utility\message\make;
use \lib\utility\human;

trait date_now
{

	/**
	 * make date_now message
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public function date_now()
	{
		$msg = \dash\date::fit_lang('l j F Y', time() , 'current');
		return $msg;
	}
}

?>