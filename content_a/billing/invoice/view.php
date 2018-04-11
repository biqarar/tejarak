<?php
namespace content_a\billing\invoice;

class view
{

	public static function config()
	{
		\dash\data::page_title(T_("Invoice Detail"));
		\dash\data::page_desc(T_("Check invoice and detail of it"));
		\dash\data::invoice(self::get_invoice());

	}


	/**
	 * get invoice data to show
	 */
	public static function get_invoice()
	{
		if(!\dash\user::login())
		{
			return false;
		}
		$invoice_id = \dash\request::get('id');
		$invoice_detail = \dash\db\invoices::load($invoice_id, \dash\user::id());
		return $invoice_detail;
	}

}
?>