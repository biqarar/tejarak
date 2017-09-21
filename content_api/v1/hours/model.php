<?php
namespace content_api\v1\hours;
use \lib\debug;
use \lib\utility;
use \lib\db\logs;
class model extends \addons\content_api\v1\home\model
{
	use tools\add;
	use tools\get;
	use tools\manage;


	/**
	 * Posts a hours.
	 * insert new hours
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_hours()
	{
		return $this->add_hours();
	}


	/**
	 * patch the ream
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function patch_hours()
	{
		return $this->add_hours(['method' => 'patch']);
	}


	/**
	 * Gets one hours.
	 *
	 * @return     <type>  One hours.
	 */
	public function get_one_hours()
	{
		return $this->get_hours();
	}


	/**
	 * Gets the hours list.
	 *
	 * @return     <type>  The hours list.
	 */
	public function get_hoursList()
	{
		return $this->get_list_hours();
	}

}
?>