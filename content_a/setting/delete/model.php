<?php
namespace content_a\setting\delete;


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
		$code = \lib\url::dir(0);
		$this->user_id = $this->login('id');
		\lib\utility::set_request_array(['id' => $code]);
		$this->close_team();
		if(\lib\debug::$status)
		{
			// \lib\debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url('a');
		}
	}
}
?>