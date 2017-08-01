<?php
namespace content_a\billing\tools;

trait data
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
		'CallbackURL' => 'https://tejarak.com/a/billing/verify/zarinpal',
		'Email'       => null,
		'Mobile'      => null,
		'Amount'      => null,
	];


	/**
	 * parsian payment ID
	 *
	 * Pin: n7RcBk5Wn5Qc033W00t3
	 * payane: 44373422
	 * @var        array
	 */
	private static $parsian =
	[
		'LoginAccount' => 'n7RcBk5Wn5Qc033W00t3',
		'Amount'       => null,
		'OrderId'      => null,
		'CallbackUrl'  => 'https://tejarak.com/a/billing/verify/parsian',
	];

}
?>