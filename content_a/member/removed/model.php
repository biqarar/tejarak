<?php
namespace content_a\member\removed;


class model extends \content_a\member\model
{

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_member($_args)
	{
		$this->user_id = \dash\user::id();
		$request       = [];
		$request['status'] = 'suspended';
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		\dash\utility::set_request_array($request);
		$result =  $this->get_list_member();

		return $result;
	}
}
?>