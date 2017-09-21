<?php
namespace content_api\v1\member;

class controller extends \addons\content_api\home\controller
{

	/**
	 * member
	 */
	public function _route()
	{

		// get member list
		$this->get('memberList')->ALL('v1/memberlist');
		// get 1 member detail
		$this->get('one_member')->ALL('v1/member');
		// add new member
		$this->post('member')->ALL('v1/member');
		$this->post('member_multi')->ALL('v1/membermulti');
		// update old member
		$this->patch('member')->ALL('v1/member');
		$this->patch('member_multi')->ALL('v1/membermulti');
	}
}
?>