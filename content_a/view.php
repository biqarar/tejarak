<?php
namespace content_a;

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
		\dash\data::display_adminTeam('content_a\main\layoutTeam.html');

		\dash\data::include_css(true);
		\dash\data::include_chart(true);

		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		// get part 2 of url and use as team name
		\dash\data::team(\dash\request::get('id'));
		\dash\data::teamCode(\dash\request::get('id'));

		if(self::reservedNames(\dash\data::team()))
		{
			\dash\data::team(null);
		}

		if(\dash\request::get('id'))
		{
			\dash\data::currentTeam(\lib\app\team::getTeamDetail(\dash\request::get('id')));
		}

		\dash\data::isAdmin(\dash\temp::get('isAdmin'));
		\dash\data::isCreator(\dash\temp::get('isCreator'));

		if(\dash\url::module() === 'member')
		{
			\content_a\member\view::config();
		}
	}


	private static function reservedNames($_name)
	{
		$result = null;
		switch ($_name)
		{
			case 'home':
			case 'team':
			case 'billing':
			case 'profile':
			case 'notifications':
				$result = true;
				break;

			default:
				$result = false;
				break;
		}
		return $result;
	}
}
?>