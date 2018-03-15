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
		if(\lib\utility::files('logo'))
		{
			$this->user_id = $this->login('id');
			\lib\utility::set_request_array(['upload_name' => 'logo']);
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
		$code = \lib\url::dir(0);
		$request       = [];

		if(\lib\utility::files('logo'))
		{
			$request['logo'] = $this->upload_logo();
		}

		$this->user_id = $this->login('id');
		$request['id'] = $code;

		\lib\utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);

		if(\lib\debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>