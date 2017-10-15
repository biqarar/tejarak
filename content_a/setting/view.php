<?php
namespace content_a\setting;

class view extends \content_a\main\view
{

	function config()
	{
		$this->data->page['title'] = T_('Setting');

		$this->data->page['desc'] = T_('Change all settings of team and edit them to customize and have a good experience.');

		// simply set title of child, if needed change it in config of them
		$child = \lib\router::get_url(2);
		if($child)
		{
			$child = ucfirst($child);
			$this->data->page['title'] .= ' | '. $child;
		}
	}
}
?>