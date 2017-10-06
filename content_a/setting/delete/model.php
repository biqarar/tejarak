<?php
namespace content_a\setting\delete;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{
	/**
	 *
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_delete()
	{
		$code = \lib\router::get_url(0);
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $code]);
		$this->close_team();
		if(debug::$status)
		{
			// debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url('a');
		}
	}
}
?>