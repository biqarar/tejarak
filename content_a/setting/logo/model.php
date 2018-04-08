<?php
namespace content_a\setting\logo;


class model extends \content_a\main\model
{

	/**
	 * Uploads a logo.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function upload_logo()
	{
		if(\dash\request::files('logo'))
		{
			$this->user_id = \dash\user::id();
			\dash\utility::set_request_array(['upload_name' => 'logo']);
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
	public function post_logo($_args)
	{
		$code = \dash\url::dir(0);
		$request       = [];

		if(\dash\request::files('logo'))
		{
			$request['logo'] = $this->upload_logo();
		}

		$this->user_id = \dash\user::id();
		$request['id'] = $code;

		\dash\utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>