<?php
namespace content_admin\company;
use \lib\utility;

class model extends \content_admin\main\model
{
	use \content_api\v1\company\tools\get;
	use \content_api\v1\company\tools\add;

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_list($_args)
	{
		$this->user_id = $this->login('id');
		$result =  $this->get_list_company();
		return $result;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
	{
		$request          = [];
		$this->user_id    = $this->login('id');
		$request['title'] = utility::post('title');
		$request['site']  = utility::post('site');
		utility::set_request_array($request);
		$this->add_company();
	}


	/**
	 * Gets the edit.
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  The edit.
	 */
	public function get_edit($_args)
	{

		if(isset($_args->match->url[0][1]))
		{
			$id = $_args->match->url[0][1];
		}
		else
		{
			return false;
		}

		$this->user_id = $this->login('id');

		utility::set_request_array(['id' => $id]);
		return $this->get_company();
	}
}
?>