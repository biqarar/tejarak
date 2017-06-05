<?php
namespace content_admin\company;
use \lib\utility;

class model extends \content_admin\main\model
{


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
	{
		$args =
		[
			'title'           => utility::post('title'),
			'site'            => utility::post('site'),
			'brand'           => utility::post('brand'),
			'register_code'   => utility::post('register_code'),
			'economical_code' => utility::post('economical_code'),
		];
		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
	{
		$request          = $this->getPost();
		$this->user_id    = $this->login('id');
		utility::set_request_array($request);
		$this->add_company();
	}


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
			$company = $_args->match->url[0][1];
		}
		else
		{
			return false;
		}

		$this->user_id = $this->login('id');

		utility::set_request_array(['company' => $company]);
		return $this->get_company();
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$request            = $this->getPost();
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$this->add_company(['method' => 'patch']);
	}


	// public function post_delete($_args)
	// {
	// 	utility::set_request_array(['brand' => utility::post('brand')]);
	// 	$this->user_id = $this->login('id');
	// 	return $this->delete_company();
	// }
}
?>