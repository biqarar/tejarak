<?php
namespace content_a\request\hour;

class view extends \content_a\main\view
{
	/**
	 * view to hour team
	 */
	public function view_hour()
	{

		$this->data->page['title'] = T_('Request edit existing hour');
		$this->data->page['desc']  = T_('you can register a change request for this time record.');
	}
}
?>