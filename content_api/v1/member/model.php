<?php
namespace content_api\v1\member;

class model extends \addons\content_api\v1\home\model
{
	use tools\add;
	use tools\get;

	/**
	 * Posts a member.
	 * insert new member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_member()
	{
		return $this->add_member();
	}


	/**
	 * patch the ream
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function patch_member()
	{
		return $this->add_member(['method' => 'patch']);
	}


	/**
	 * Gets one member.
	 *
	 * @return     <type>  One member.
	 */
	public function get_one_member()
	{
		return $this->get_member();
	}


	/**
	 * Gets the member list.
	 *
	 * @return     <type>  The member list.
	 */
	public function get_memberList()
	{
		return $this->get_list_member();
	}


	/**
	 * add multi record
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function member_multi($_method)
	{
		$all_request = \dash\utility::request();
		$result = [];
		if(is_array($all_request))
		{
			foreach ($all_request as $key => $value)
			{
				\dash\utility::set_request_array($value);
				$result[] = $this->add_member(['method' => $_method]);
				\lib\engine\process::status() = 1;
			}
		}
		return $result;
	}



	/**
	 * add multi record
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_member_multi()
	{
		return $this->member_multi('post');
	}


	/**
	 * patch multi record
	 * sync record
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function patch_member_multi()
	{
		return $this->member_multi('patch');
	}
}
?>