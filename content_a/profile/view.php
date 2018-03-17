<?php
namespace content_a\profile;

class view extends \content_a\main\view
{
	public function view_profile()
	{
		if(\lib\user::login('unit_id'))
		{
			$this->data->user_unit = \lib\utility\units::get(\lib\user::login('unit_id'), true);
		}
	}
}
?>