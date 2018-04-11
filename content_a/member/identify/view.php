<?php
namespace content_a\member\identify;

class view
{

	public static function config()
	{
		\dash\data::page_title(T_('Personnel Card'));
		\dash\data::page_desc(T_('You can set special verify code for member, like rfid card, barcode or qrcode and we allow you to use this codes on board.'));
	}

}
?>