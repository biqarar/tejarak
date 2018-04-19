<?php
require_once('social.php');
require_once('notification.php');
require_once('payment.php');
require_once('sms.php');

/**
 * save logs in other database
 */
if(!defined('db_log_name'))
{
	define('db_log_name', 'tejarak_log');
}



/**
@ In the name Of Allah
* The base configurations of the tejarak.
*/
self::$language =
[
	'default' => 'fa',
	'list'    => ['fa','en',],
];
/**
 * system default lanuage
 */

// fix url and redirect
// http://tejarak.ir
// to https://tejarak.com
self::$url['tld']                   = 'com';
self::$url['protocol']              = 'https';



self::$config['debug']              = false;
self::$config['coming']             = false;
self::$config['redirect']           = 'a';





/**
 * call kavenegar template
 */
self::$config['enter']['call']                = true;
self::$config['enter']['call_template_fa'] = 'ermile-fa';
self::$config['enter']['call_template_en'] = 'ermile-en';

/**
 * telegram hook
 */
self::$config['enter']['telegram_hook']   = '**Ermile**vHTnEoYth43MwBH7o6mPk807Tejarakf0DUbXZ7k2Bju5n^^Telegram^^';
// static token
// get the user id by mobile in api header
self::$config['enter']['static_token'][]  = '**Ermile**Azvir^^Tejarak--Token__Static++6mPf0DUbXZ7kth43MwBH7o6mPk8';

/**
 * first signup url
 * main redirect url . signup redirect url
 */
self::$config['enter']['singup_redirect']     = 'a';


/**
 * cronjob urls and status
 */
self::$config['cronjob']['status'] = true;


/**
 * list of units
 */
self::$config['units'] =
[
	1 =>
	[
		'title' => 'toman',
		'desc'  => "Toman",
	],

	2 =>
	[
		'title' => 'dollar',
		'desc'  => "$",
	],
];
// the unit id for default
self::$config['default_unit'] = 1;
// force change unit to this unit
self::$config['force_unit']   = 1;

/**
 * transaction code
 */
self::$config['transactions_code'][100] = "invoice:team";
self::$config['transactions_code'][150] = "promo:ref";

self::$config['enter']['verify_telegram'] = true;
self::$config['enter']['verify_sms']      = true;
self::$config['enter']['verify_call']     = true;
self::$config['enter']['verify_sendsms']  = true;



?>