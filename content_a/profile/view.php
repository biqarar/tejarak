<?php
namespace content_a\profile;

class view extends \content_a\main\view
{
	public function view_profile()
	{
		if(\dash\user::login('unit_id'))
		{
			$this->data->user_unit = \dash\app\units::get(\dash\user::login('unit_id'), true);
		}
	}
}
?>