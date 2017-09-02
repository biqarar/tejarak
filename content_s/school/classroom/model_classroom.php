<?php
namespace content_s\school\classroom;
use \lib\utility;
use \lib\debug;

trait model_classroom
{
	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPostClassroom()
	{
		$args =
		[
			'name'              => utility::post('name'),
			'type' 				=> 'classroom',
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
	 * add new classroom
	 */
	public function post_classroom_add()
	{
		$request          = $this->getPostClassroom();
		if($request === false)
		{
			return false;
		}
		$this->user_id     = $this->login('id');
		$parent            = \lib\router::get_url(0);
		$request['parent'] = $parent;
		$request['type']   = 'classroom';
		utility::set_request_array($request);

		$this->add_team();

		if(debug::$status)
		{
			$new_team_code = \lib\storage::get_last_team_code_added();

			if($new_team_code)
			{
				debug::msg('direct', true);
				$this->redirector()->set_domain()->set_url("s/$parent/classroom");
			}
		}
	}


	public function classroomList($_meta = [])
	{
		$parent         = \lib\router::get_url(0);
		$meta           = [];
		$meta['parent'] = \lib\utility\shortURL::decode($parent);
		$meta['type']   = 'classroom';
		$meta['status'] = 'enable';
		$search         = null;
		if(isset($_meta['search']))
		{
			$search = $_meta['search'];
		}
		$resutl = \lib\db\teams::search($search, $meta);
		return $resutl;
	}


	/**
	 * load team data to load for edit
	 *
	 * @param      <type>  $_code  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editClassroom($_code)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $_code]);
		$result = $this->get_team();
		return $result;
	}

	/**
	 *
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_closeClassroom($_args)
	{
		$school = \lib\router::get_url(0);
		$code = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $code]);
		$this->close_team();
		if(debug::$status)
		{
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$school/classroom");
		}
	}


	/**
	 * Posts a classroom edit.
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function post_classroom_edit($_args)
	{
		$code = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		// if delete link is clicked
		// go to delete function and return
		if(utility::post('delete'))
		{
			$this->post_closeClassroom($_args);
			return;
		}

		$request       = $this->getPostClassroom();

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
			$school = \lib\router::get_url(0);
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$school/classroom");
		}
	}

}
?>