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
			'displayname'      => \lib\utility::post('name'),
			'postion'          => \lib\utility::post('postion'),
			'mobile'           => \lib\utility::post('mobile'),
			'rule'             => \lib\utility::post('rule'),
			'firstname'        => \lib\utility::post('firstName'),
			'lastname'         => \lib\utility::post('lastName'),
			'personnel_code'   => \lib\utility::post('personnelcode'),
			'allow_plus'       => \lib\utility::post('allowPlus'),
			'allow_minus'      => \lib\utility::post('allowMinus'),
			'remote_user'      => \lib\utility::post('remoteUser'),
			'24h'              => \lib\utility::post('24h'),
			'status'           => \lib\utility::post('status'),
			'visibility'       => \lib\utility::post('visibility'),
			'barcode1'         => \lib\utility::post('barcode'),
			'rfid1'            => \lib\utility::post('rfid'),
			'qrcode1'          => \lib\utility::post('qrcode'),
			'allow_desc_enter' => \lib\utility::post('allowDescEnter'),
			'allow_desc_exit'  => \lib\utility::post('allowDescExit'),
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
		if(\lib\utility::files('avatar'))
		{
			\lib\utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['\lib\debug' => false]);
			if(isset($uploaded_file['code']))
			{
				return $uploaded_file['code'];
			}
			// if in upload have error return
			if(!\lib\debug::$status)
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
		$this->user_id    = $this->login('id');
		$request          = [];
		$request['team']  = $_team;
		$request['id']    = $_member;
		\lib\utility::set_request_array($request);
		$result           =  $this->get_member();
		// $member_id        = \lib\utility\shortURL::decode($_member);
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
		if(!$this->login())
		{
			\lib\debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = $this->login('id');
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

		$url             = \lib\url::directory();
		$member          = \lib\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(\lib\debug::$status)
		{
			if(\lib\utility::post('parent_mobile'))
			{
				$parent_request               = [];
				$parent_request['othertitle'] = \lib\utility::post('othertitle');
				$parent_request['id']    = $member;
				$parent_request['title']      = \lib\utility::post('title');
				$parent_request['mobile']     = \lib\utility::post('parent_mobile');
				\lib\utility::set_request_array($parent_request);
				$this->add_parent();
			}
		}

		if(\lib\debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/member");
		}
	}
}
?>