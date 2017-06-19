<?php
namespace mvc;

class view extends \lib\mvc\view
{
	function _construct()
	{
		// define default value for global

		$this->data->site['title']       = T_("Tejarak");
		$this->data->site['desc']        = T_("Tejarak provides beautiful solutions for your business").  T_("Do attendance easily and enjoy realtime reports. With simple pricing");
		$this->data->site['slogan']      = T_("Modern Approach");

		$this->data->page['desc']        = $this->data->site['slogan'];
		$this->data->display['ganje']    = "content_ganje/home/layout.html";
		$this->data->display['tejarak']  = "content_a/main/display.html";
		$this->data->display['ganje_et'] = "content_ganje/home/et.html";
		$this->data->bodyclass           = 'unselectable';

		// for pushstate of main page
		$this->data->template['xhr']     = 'content/main/layout-xhr.html';

		$this->data->display['admin']    = 'content_a/main/layout.html';
		$this->data->template['social']  = 'content/template/social.html';
		$this->data->template['share']   = 'content/template/share.html';

		// get total uses
		$total_users                     = intval(\lib\utility\users::tejarak_total_users());
		$total_users                     = number_format($total_users);
		$this->data->total_users         = \lib\utility\human::number($total_users);
		$this->data->footer_stat         = T_("We help :count people to work beter!", ['count' => $this->data->total_users]);

		$this->include->css_ermile       = false;
		// $this->include->js_main       = false;
		$this->include->css              = false;
		// $this->include->js            = false;

		// if you need to set a class for body element in html add in this value
		$this->data->bodyclass           = null;

		if(method_exists($this, 'options'))
		{
			$this->options();
		}
	}


	/**
	 * [pushState description]
	 * @return [type] [description]
	 */
	function pushState()
	{
		if($this->url('sub') === 'ganje')
		{
			$this->data->display['ganje']     = "content_ganje/home/layout-xhr.html";
		}
	}
}
?>