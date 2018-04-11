<?php
namespace content_a\setting\security;

class view
{

	public static function config()
	{
		\dash\data::page_title(T_('Setting'). ' | '. T_('Security and Privacy'));
		$request_data = \content_a\setting\security\model::load_last_request();
		\dash\data::sendedData($request_data);
	}

}
?>