<?php
namespace content_a\team\add;
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
			'name'              => utility::post('name'),
			'website'           => utility::post('website'),
			'privacy'           => utility::post('privacy'),
			'short_name'        => utility::post('shortName'),
			'desc'              => utility::post('desc'),
			'show_avatar'       => utility::post('showAvatar'),
			'quick_traffic'     => utility::post('quickTraffic'),
			'allow_plus'        => utility::post('allowPlus'),
			'allow_minus'       => utility::post('allowMinus'),
			'remote_user'       => utility::post('remoteUser'),
			'24h'               => utility::post('24h'),
			'manual_time_enter' => utility::post('manual_time_enter'),
			'manual_time_exit'  => utility::post('manual_time_exit'),
			'language'          => utility::post('language'),
			'event_title'       => utility::post('event_title'),
			'event_date'        => utility\human::number(utility::post('event_date'), 'en'),
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
			$new_team_code = \lib\temp::get('last_team_code_added');

			if($new_team_code)
			{
				// debug::msg('direct', true);
				$this->redirector()->set_domain()->set_url("a/$new_team_code");
			}
		}

	}
}
?>