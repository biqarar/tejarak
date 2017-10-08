<?php
namespace content_a\team\add;

class view extends \content_a\main\view
{
	/**
	 * view to add team
	 */
	public function view_add()
	{
		$this->data->page['title'] = T_('Add new team');
		$this->data->page['desc']  = T_('Set some basic detail, after insert you can add avatar and change all settings');
	}
}
?>