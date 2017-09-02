<?php
namespace content_s\terms;

class view extends \content_s\main\view
{

	/**
	 * { function_description }
	 */
	public function view_terms()
	{
		$this->data->terms_list   = $this->model()->getListterms();
		$this->data->page['title'] = T_('Add new terms');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * view to add team
	 */
	public function view_terms_add()
	{
		$this->data->page['title'] = T_('Add new terms');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * load team data to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_terms_edit($_args)
	{
		$terms_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$this->data->terms = $this->model()->termsEdit($terms_id);

		$this->data->edit_mode = true;

		if(isset($this->data->terms['title']))
		{
			$this->data->page['title'] = T_('Edit terms');
			$this->data->page['desc']  = T_("Edit terms :name", ['name' => $this->data->terms['title']]);
		}
	}


}
?>