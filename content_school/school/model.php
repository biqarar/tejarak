<?php
namespace content_school\school;
use \lib\utility;
use \lib\debug;

class model extends \content_school\main\model
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
			'name'              => utility::post('name'),
			'type' 				=> 'school',
			'website'           => utility::post('website'),
			'privacy'           => utility::post('privacy'),
			'short_name'        => utility::post('shortName'),
			'desc'              => utility::post('desc'),
			'show_avatar'       => utility::post('showAvatar'),
			'allow_plus'        => utility::post('allowPlus'),
			'allow_minus'       => utility::post('allowMinus'),
			'remote_user'       => utility::post('remoteUser'),
			'24h'               => utility::post('24h'),
			'manual_time_enter' => utility::post('manual_time_enter'),
			'manual_time_exit'  => utility::post('manual_time_exit'),
			'language'          => utility::post('language'),
			'event_title'       => utility::post('event_title'),
			'event_date'        => utility::post('event_date'),
			'cardsize'          => utility::post('cardsize'),
			'allow_desc_enter'  => utility::post('allowDescEnter'),
			'allow_desc_exit'   => utility::post('allowDescExit'),
			// 'parent'      => utility::post('the-parent'),
		];

		if(utility::files('logo'))
		{
			$args['logo'] = $this->upload_logo();
		}

		/**
		 * if the user not check parent check box
		 * not save the parent
		 */
		// if(!utility::post('parent'))
		// {
		// 	$args['parent'] = null;
		// }

		// if(utility::post('parent') && !utility::post('the-parent'))
		// {
		// 	debug::error(T_("Please select the parent team"), 'the-parent');
		// 	return false;
		// }
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
		if($request === false)
		{
			return false;
		}
		$this->user_id    = $this->login('id');
		utility::set_request_array($request);
		$this->add_team();

		if(debug::$status)
		{
			$new_team_code = \lib\storage::get_last_team_code_added();

			if($new_team_code)
			{
				debug::msg('direct', true);
				$this->redirector()->set_domain()->set_url("school/$new_team_code");
			}
		}

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
		$result = $this->get_team();
		// var_dump($result);exit();
		return $result;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$code = \lib\router::get_url(0);

		// if delete link is clicked
		// go to delete function and return
		if(utility::post('delete'))
		{
			$this->post_close();
			return;
		}

		$request       = $this->getPost();

		if($request === false)
		{
			return false;
		}

		$this->user_id = $this->login('id');
		$request['id'] = $code;

		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
		if(debug::$status)
		{
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("school/$code");
		}
	}


	/**
	 *
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_close()
	{
		$code = \lib\router::get_url(0);
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $code]);
		$this->close_team();
		if(debug::$status)
		{
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url('school');
		}
	}
}
?>