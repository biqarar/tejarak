<?php
namespace content_s\terms;

class controller extends \content_s\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();


		// ADD NEW terms
		$this->get(false, 'terms_add')->ALL("/^([a-zA-z0-9]+)\/terms\/add$/");
		$this->post('terms_add')->ALL("/^([a-zA-z0-9]+)\/terms\/add$/");

		// LIST terms
		$this->get(false, 'terms')->ALL("/^([a-zA-z0-9]+)\/terms$/");
		$this->post('terms')->ALL("/^([a-zA-z0-9]+)\/terms$/");

		// EDIT terms
		$this->get(false, 'terms_edit')->ALL("/^([a-zA-z0-9]+)\/terms\=([a-zA-Z0-9]+)$/");
		$this->post('terms_edit')->ALL("/^([a-zA-z0-9]+)\/terms\=([a-zA-Z0-9]+)$/");

		if(preg_match("/^([a-zA-z0-9]+)\/terms$/", $url))
		{
			$this->display_name = 'content_s\terms\termsList.html';
		}

	}
}
?>