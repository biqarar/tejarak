<?php
namespace content_a\team;
use \lib\utility;
use \lib\debug;

class model extends \content_a\main\model
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
			'name'        => utility::post('name'),
			'website'     => utility::post('website'),
			'privacy'     => utility::post('privacy'),
			'short_name'  => utility::post('shortName'),
			'desc'        => utility::post('desc'),
			'show_avatar' => utility::post('showAvatar'),
			'allow_plus'  => utility::post('allowPlus'),
			'allow_minus' => utility::post('allowMinus'),
			'remote_user' => utility::post('remoteUser'),
			'24h'         => utility::post('24h'),
		];

		if(utility::files('logo'))
		{
			$args['logo'] = $this->upload_logo();
		}

		return $args;
	}


	/**
	 * Uploads a logo.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function upload_logo()
	{
		if(utility::files('logo'))
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['upload_name' => 'logo']);
			$uploaded_file = $this->upload_file(['debug' => false]);
			if(isset($uploaded_file['code']))
			{
				return $uploaded_file['code'];
			}
		}
		return null;
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
	 * @param      <type>  $_code  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_code)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $_code]);
		return $this->get_team();
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$code = \lib\router::get_url(1);

		// if delete link is clicked
		// go to delete function and return
		if(utility::post('delete'))
		{
			$this->post_delete($team);
			return;
		}

		$request       = $this->getPost();
		$this->user_id = $this->login('id');
		$request['id'] = $code;

		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}


	/**
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_delete($_team)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['team' => $_team]);
		return $this->delete_team();
	}
}
?>