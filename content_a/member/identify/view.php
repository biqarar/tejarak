<?php
namespace content_a\member\identify;

class view extends \content_a\member\view
{

	/**
	 * identify member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_identify($_args)
	{

		$this->data->page['title'] = T_('Personnel Card');
		$this->data->page['desc']  = T_('You can set special verify code for member, like rfid card, barcode or qrcode and we allow you to use this codes on board.');

	}

}
?>