<?php
namespace content_a\profile;

class view
{
	public static function config()
	{
		if(\dash\user::login('unit_id'))
		{
			\dash\data::userUnit(\dash\app\units::get(\dash\user::login('unit_id'), true));
		}
	}
}
?>