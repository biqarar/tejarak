<?php
namespace content_a\profile;

class view extends \content_a\main\view
{
	public function view_profile()
	{
		if($this->login('unit_id'))
		{
			$this->data->user_unit = \lib\db\units::get($this->login('unit_id'), true);
		}
	}
}
?>