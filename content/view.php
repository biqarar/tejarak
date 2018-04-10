<?php
namespace content;

class view
{
	public static function config()
	{
		// define default value for global

		\dash\data::site_title(T_("Tejarak"));
		\dash\data::site_desc(T_("Tejarak provides beautiful solutions for your business;"). ' '.  T_("Do attendance easily and enjoy realtime reports."));
		\dash\data::site_slogan(T_("Modern Approach"));

		\dash\data::page_desc(\dash\data::site_desc(). ' | '. \dash\data::site_slogan());

		// for pushstate of main page
		\dash\data::template_xhr('content/main/layout-xhr.html');

		\dash\data::display_admin('content_a/main/layout.html');
		\dash\data::template_social('content/template/social.html');
		\dash\data::template_share('content/template/share.html');
		\dash\data::template_price('content/template/priceTable.html');
		\dash\data::template_priceSchool('content/template/priceSchoolTable.html');

		// get total uses
		$total_users             = ceil(intval(\lib\db\hours::sum_total_hours()) / 60);
		$total_users             = number_format($total_users);
		$total_users             = \dash\utility\human::number($total_users);
		\dash\data::footer_stat(T_("We registered :count work hour in tejarak!", ['count' => $total_users]));


		\dash\data::include_css(false);
	}
}
?>