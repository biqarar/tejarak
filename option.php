<?php
/**
@ In the name Of Allah
* The base configurations of the tejarak.
*/
self::$language =
[
	'default' => 'en',
	'list'    => ['fa','en',],
];

self::$config['default_language']             = 'en';

self::$config['redirect_url']                 = 'http://tejarak.dev';
self::$config['multi_domain']                 = true;
self::$config['redirect_to_main']             = true;
self::$config['https']                        = false;
self::$config['default_tld']                  = 'dev';
self::$config['default_permission']           = null;
self::$config['debug']                        = true;
self::$config['coming']                       = false;
self::$config['short_url']                    = null;
self::$config['save_as_cookie']               = false;
self::$config['log_visitors']                 = true;
self::$config['passphrase']                   = null;
self::$config['passkey']                      = null;
self::$config['passvalue']                    = null;
self::$config['default']                      = null;
self::$config['redirect']                     = 'a';
self::$config['register']                     = true;
self::$config['recovery']                     = true;
self::$config['fake_sub']                     = null;
self::$config['real_sub']                     = true;
self::$config['force_short_url']              = null;
self::$config['sms']                          = true;

self::$config['account']                      = true;
self::$config['main_account']                 = null;
self::$config['account_status']               = true;
self::$config['use_main_account']             = false;

self::$config['domain_same']                  = true;
self::$config['domain_name']                  = 'tejarak';
self::$config['main_site']                    = 'http://tejarak.dev';


/**
* the social network
*/
self::$social['status']                       = true;

self::$social['list']['telegram']             = 'tejarak';
self::$social['list']['facebook']             = 'tejarak.ermile';
self::$social['list']['twitter']              = 'ermile_tejarak';
self::$social['list']['instagram']            = 'ermile_tejarak';
self::$social['list']['googleplus']           = '113130164586721131168';
self::$social['list']['github']               = 'ermile';
self::$social['list']['linkedin']             = null;
self::$social['list']['aparat']               = 'tejarak';

/**
* TELEGRAM
* t.me
*/
self::$social['telegram']['status']           = true;
self::$social['telegram']['name']             = null;
self::$social['telegram']['key']              = null;
self::$social['telegram']['bot']              = null;
self::$social['telegram']['hookFolder']       = null;
self::$social['telegram']['hook']             = null;
self::$social['telegram']['debug']            = true;
self::$social['telegram']['channel']          = null;
self::$social['telegram']['botan']            = null;

/**
* FACEBOOK
*/
self::$social['facebook']['status']           = true;
self::$social['facebook']['name']             = 'tejarak';
self::$social['facebook']['key']              = null;
self::$social['facebook']['app_id']           = '236377626849014';
self::$social['facebook']['app_secret']       = 'c7055125a0e70d2125664b009df3f3cd';
self::$social['facebook']['api_version']      = '2.9';
self::$social['facebook']['redirect_url']     = null;
self::$social['facebook']['required_scope']   = null;
self::$social['facebook']['page_id']          = null;
self::$social['facebook']['access_token']     = null;
self::$social['facebook']['client_token']     = 'df0047eb1af1e2acba2a3645bcb4f472';

/**
* GOOGLE
*/
// self::$social['google']['status']                      = true;
// self::$social['google']['client_id']                   = '395232553225-140n5eq7ha34thagrbcnns125ocmqk96.apps.googleusercontent.com';
// self::$social['google']['project_id']                  = 'ermile-tejarak';
// self::$social['google']['auth_uri']                    = 'https://accounts.google.com/o/oauth2/auth';
// self::$social['google']['token_uri']                   = 'https://accounts.google.com/o/oauth2/token';
// self::$social['google']['auth_provider_x509_cert_url'] = 'https://www.googleapis.com/oauth2/v1/certs';
// self::$social['google']['client_secret']               = 'h3q_yNJFqbqO5SV-PK2cXMmc';



self::$social['google']['status']                      = true;
self::$social['google']['client_id']                   = '395232553225-5filcn07d2rdjl2fld57mf8e50ac146j.apps.googleusercontent.com';
self::$social['google']['project_id']                  = 'ermile-tejarak';
self::$social['google']['auth_uri']                    = 'https://accounts.google.com/o/oauth2/auth';
self::$social['google']['token_uri']                   = 'https://accounts.google.com/o/oauth2/token';
self::$social['google']['auth_provider_x509_cert_url'] = 'https://www.googleapis.com/oauth2/v1/certs';
self::$social['google']['client_secret']               = 'oo6LPHZXJA6JWkgPgPb7uJ0U';



// {
//   "web": {
//     "client_id": "395232553225-5filcn07d2rdjl2fld57mf8e50ac146j.apps.googleusercontent.com",
//     "project_id": "ermile-tejarak",
//     "auth_uri": "https://accounts.google.com/o/oauth2/auth",
//     "token_uri": "https://accounts.google.com/o/oauth2/token",
//     "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
//     "client_secret": "oo6LPHZXJA6JWkgPgPb7uJ0U",
//     "redirect_uris": [
//       "https://tejarak.com/enter/google"
//     ]
//   }
// }



/**
* TWITTER
*/
self::$social['twitter']['status']            = false;
self::$social['twitter']['name']              = 'tejarak';
self::$social['twitter']['key']               = null;
self::$social['twitter']['ConsumerKey']       = null;
self::$social['twitter']['ConsumerSecret']    = null;
self::$social['twitter']['AccessToken']       = null;
self::$social['twitter']['AccessTokenSecret'] = null;

/**
* GOOGLE PLUS
*/
self::$social['googleplus']['status']         = false;
self::$social['googleplus']['name']           = '109727653714508522373';
self::$social['googleplus']['key']            = null;


/**
* GITHUB
*/
self::$social['github']['status']             = false;
self::$social['github']['name']               = 'ermile';
self::$social['github']['key']                = null;


/**
* LINKDIN
*/
self::$social['linkedin']['status']           = false;
self::$social['linkedin']['name']             = null;
self::$social['linkedin']['key']              = null;


/**
* APARAT
*/
self::$social['aparat']['status']             = false;
self::$social['aparat']['name']               = 'tejarak';
self::$social['aparat']['key']                = null;


/**
* sms kavenegar config
*/
self::$sms['kavenegar']['value']              = 'kavenegar_api';
self::$sms['kavenegar']['status']             = true;
self::$sms['kavenegar']['apikey']             = '783067644A597A41716F3734755A683152736F6673773D3D';
self::$sms['kavenegar']['debug']              = null;
self::$sms['kavenegar']['line1']              = '10006660066600';
self::$sms['kavenegar']['line2']              = null;
self::$sms['kavenegar']['iran']               = null;
self::$sms['kavenegar']['header']             = null;
self::$sms['kavenegar']['footer']             = 'tejarak';
self::$sms['kavenegar']['one']                = true;
self::$sms['kavenegar']['signup']             = true;
self::$sms['kavenegar']['verification']       = true;
self::$sms['kavenegar']['recovery']           = true;
self::$sms['kavenegar']['changepass']         = true;


/**
 * telegram hook
 */
self::$enter['telegram_hook']   = '**Ermile**vHTnEoYth43MwBH7o6mPk807Tejarakf0DUbXZ7k2Bju5n^^Telegram^^';
/**
 * first signup url
 * main redirect url . signup redirect url
 */
self::$enter['singup_redirect'] = 'a/setup';



?>