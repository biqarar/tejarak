<?php
namespace content_admin\billing\tools;

trait zarinpal
{
	/**
	 * zarinpay method
	 *
	 * @var        array
	 */
	private static $zarinpal =
	[
		'MerchantID'  => "c2bf5bee-4d2a-11e7-93bb-000c295eb8fc",
		'Description' => "Tejarak",
		'CallbackURL' => 'https://tejarak.com/admin/billing/verify/zarinpal',
		'Email'       => null,
		'Mobile'      => null,
		'Amount'      => null,
	];


}
?>