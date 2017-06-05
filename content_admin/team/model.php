<?php
namespace content_admin\team;
use \lib\utility;
use \lib\debug;

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
		$this->add_team();
	}


	/**
	 * load team data to load for edit
	 *
	 * @param      <type>  $_team  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['team' => $_team]);
		return $this->get_team();
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$brand = $this->view()->find_team_name_url($_args);
		// if delete link is clicked
		// go to delete function and return
		if(utility::post('delete'))
		{
			$this->post_delete($brand);
			return;
		}

		$request         = $this->getPost();
		$this->user_id   = $this->login('id');
		$request['team'] = $brand;
		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
		if(debug::$status)
		{
			$new_brand = \lib\storage::get_last_team_added();

			if($new_brand && $new_brand != $request['team'])
			{
				$this->redirector()->set_domain()->set_url("admin/team/$new_brand");
			}
		}
	}


	/**
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_delete($_brand)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['brand' => $_brand]);
		return $this->delete_team();
	}
}
?>