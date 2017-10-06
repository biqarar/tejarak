<?php
namespace content_a\setting\security;

class view extends \content_a\setting\view
{

	public function config()
	{
		parent::config();
		$this->data->page['title']  = T_('Setting'). ' | '. T_('Security and Privacy');
		// $this->data->page['desc']  = T_('');
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_security($_args)
	{
		$request_data = $this->model()->load_last_request();
		$this->data->sended_data = $request_data;
	}
}
?>