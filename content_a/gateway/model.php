<?php
namespace content_a\gateway;


class model extends \content_a\main\model
{


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_gateway($_args)
	{
		$this->user_id = \dash\user::id();
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		\dash\app::variable($request);
		$result =  $this->get_list_gateway();
		return $result;
	}
}
?>