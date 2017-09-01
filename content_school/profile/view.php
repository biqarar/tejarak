<?php
namespace content_school\profile;

class view extends \content_school\main\view
{
	public function view_profile()
	{
		if($this->login('unit_id'))
		{
			$this->data->user_unit = \lib\utility\units::get($this->login('unit_id'), true);
		}
	}
}
?>