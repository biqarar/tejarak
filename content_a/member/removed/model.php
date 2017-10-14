<?php
namespace content_a\member\removed;
use \lib\utility;
use \lib\debug;

class model extends \content_a\member\model
{

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_member($_args)
	{
		$this->user_id = $this->login('id');
		$request       = [];
		$request['status'] = 'suspended';
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_member();

		return $result;
	}
}
?>