<?php
namespace content_s\studentpanel;
use \lib\debug;
use \lib\utility;

class model extends \content_s\main\model
{


	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function loadPanel($_member)
	{
		$this->user_id   = $this->login('id');
		$request         = [];
		$request['team'] = \lib\router::get_url(0);
		$request['id']   = $_member;
		$request['type'] = 'student';
		utility::set_request_array($request);
		$result           =  $this->get_member();

		if($result)
		{
			$member_id        = \lib\utility\shortURL::decode($_member);
			$this->user_id    = $member_id;
			$parent           = $this->get_list_parent();
			$result['parent'] = $parent;
		}
		return $result;
	}
}
?>