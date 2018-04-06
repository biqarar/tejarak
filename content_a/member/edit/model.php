<?php
namespace content_a\member\edit;


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
			'displayname'      => \dash\request::post('name'),
			'postion'          => \dash\request::post('postion'),
			'mobile'           => \dash\request::post('mobile'),
			'rule'             => \dash\request::post('rule'),
			'firstname'        => \dash\request::post('firstName'),
			'lastname'         => \dash\request::post('lastName'),
			'personnel_code'   => \dash\request::post('personnelcode'),
			'allow_plus'       => \dash\request::post('allowPlus'),
			'allow_minus'      => \dash\request::post('allowMinus'),
			'remote_user'      => \dash\request::post('remoteUser'),
			'24h'              => \dash\request::post('24h'),
			'status'           => \dash\request::post('status'),
			'visibility'       => \dash\request::post('visibility'),
			'barcode1'         => \dash\request::post('barcode'),
			'rfid1'            => \dash\request::post('rfid'),
			'qrcode1'          => \dash\request::post('qrcode'),
			'allow_desc_enter' => \dash\request::post('allowDescEnter'),
			'allow_desc_exit'  => \dash\request::post('allowDescExit'),
		];

		return $args;
	}



	/**
	 * Uploads an avatar.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function upload_avatar()
	{
		if(\dash\request::files('avatar'))
		{
			\lib\utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['\lib\notif' => false]);
			if(isset($uploaded_file['code']))
			{
				return $uploaded_file['code'];
			}
			// if in upload have error return
			if(!\lib\engine\process::status())
			{
				return false;
			}
		}
		return null;
	}



	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team, $_member)
	{
		$this->user_id    = \lib\user::id();
		$request          = [];
		$request['team']  = $_team;
		$request['id']    = $_member;
		\lib\utility::set_request_array($request);
		$result           =  $this->get_member();
		// $member_id        = \lib\coding::decode($_member);
		\lib\utility::set_request_array(['id' => $_member]);
		$parent           = $this->get_list_parent();
		$result['parent'] = $parent;

		return $result;
	}


	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		// check the user is login
		if(!\lib\user::login())
		{
			\lib\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = \lib\user::id();
		$request       = $this->getPost();
		$file_code     = $this->upload_avatar();
		// we have an error in upload avatar
		if($file_code === false)
		{
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$url             = \dash\url::directory();
		$member          = \dash\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \dash\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(\lib\engine\process::status())
		{
			if(\dash\request::post('parent_mobile'))
			{
				$parent_request               = [];
				$parent_request['othertitle'] = \dash\request::post('othertitle');
				$parent_request['id']    = $member;
				$parent_request['title']      = \dash\request::post('title');
				$parent_request['mobile']     = \dash\request::post('parent_mobile');
				\lib\utility::set_request_array($parent_request);
				$this->add_parent();
			}
		}

		if(\lib\engine\process::status())
		{
			\lib\redirect::to(\dash\url::here(). "/$team/member");
		}
	}
}
?>