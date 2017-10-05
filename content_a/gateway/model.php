<?php
namespace content_a\gateway;
use \lib\utility;
use \lib\debug;

class model extends \content_a\main\model
{


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_gateway($_args)
	{
		$this->user_id = $this->login('id');
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_gateway();
		return $result;
	}
}
?>