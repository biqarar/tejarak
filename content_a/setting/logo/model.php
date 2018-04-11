<?php
namespace content_a\setting\logo;


class model
{

	/**
	 * Uploads a logo.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function upload_logo()
	{
		if(\dash\request::files('logo'))
		{

			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'logo']);
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
	public static function post()
	{
		$code = \dash\request::get('id');
		$request       = [];

		if(\dash\request::files('logo'))
		{
			$request['logo'] = self::upload_logo();
		}


		$request['id'] = $code;

		\dash\app::variable($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		\lib\app\team::add_team(['method' => 'patch']);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>