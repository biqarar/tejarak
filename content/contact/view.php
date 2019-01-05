<?php
namespace content\contact;

class view extends \content_support\ticket\contact_ticket\view
{
	public static function config()
	{
		\dash\data::page_title(\dash\url::module());
		\dash\data::bodyclass('unselectable vflex');
		self::codeurl();

	}
}
?>