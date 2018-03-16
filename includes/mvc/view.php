<?php
namespace mvc;

class view extends \lib\view
{
	function project()
	{
		// define default value for global

		$this->data->site['title']           = T_("Tejarak");
		$this->data->site['desc']            = T_("Tejarak provides beautiful solutions for your business;"). ' '.  T_("Do attendance easily and enjoy realtime reports.");
		$this->data->site['slogan']          = T_("Modern Approach");

		$this->data->page['desc']            = $this->data->site['desc']. ' | '. $this->data->site['slogan'];

		$this->data->bodyclass               = 'unselectable';

		// for pushstate of main page
		$this->data->template['xhr']         = 'content/main/layout-xhr.html';

		$this->data->display['admin']        = 'content_a/main/layout.html';
		$this->data->template['social']      = 'content/template/social.html';
		$this->data->template['share']       = 'content/template/share.html';
		$this->data->template['price']       = 'content/template/priceTable.html';
		$this->data->template['priceSchool'] = 'content/template/priceSchoolTable.html';

		if(in_array(\lib\engine\content::name(), ['content']))
		{
			// get total uses
			$total_users                     = ceil(intval(\lib\db\hours::sum_total_hours()) / 60);
			$total_users                     = number_format($total_users);
			$this->data->total_users         = \lib\utility\human::number($total_users);
			// $this->data->footer_stat         = T_("We help :count people to work beter!", ['count' => $this->data->total_users]);
			$this->data->footer_stat         = T_("We registered :count work hour in tejarak!", ['count' => $this->data->total_users]);
		}

		$this->include->css_ermile       = false;
		// $this->include->js_main       = false;
		$this->include->css              = false;
		// $this->include->js            = false;

		// if you need to set a class for body element in html add in this value
		$this->data->bodyclass           = null;

	}


	/**
	 * [pushState description]
	 * @return [type] [description]
	 */
	// function pushState()
	// {

	// }
}
?>