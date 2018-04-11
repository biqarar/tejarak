<?php
namespace content_a\member\removed;


class model
{

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function listMember($_args)
	{
		$this->user_id = \dash\user::id();
		$request       = [];
		$request['status'] = 'suspended';
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		\dash\app::variable($request);
		$result =  $this->get_listMember();

		return $result;
	}
}
?>