<?php


/**
* cofig of zarinpal payment
*/
self::$config['zarinpal']['status']      = true;
self::$config['zarinpal']['MerchantID']  = "c2bf5bee-4d2a-11e7-93bb-000c295eb8fc";
self::$config['zarinpal']['Description'] = "Tejarak";
// set the call back is null to redirecto to default dash callback payment
self::$config['zarinpal']['CallbackURL'] = null;
// all amount of this payment * exchange of this payment to change all units to default units of dash
self::$config['zarinpal']['exchange']    = 1;


/**
* config of parsian payment
*/
self::$config['parsian']['status']       = true;
self::$config['parsian']['LoginAccount'] = 'n7RcBk5Wn5Qc033W00t3';
// set the call back is null to redirecto to default dash callback payment
self::$config['parsian']['CallBackUrl']  = null;
// all amount of this payment * exchange of this payment to change all units to default units of dash
self::$config['parsian']['exchange']     = 10;


/**
* config of irkish payment
*/
self::$config['irkish']['status']      = true;
self::$config['irkish']['merchantId']  = 'C3FC'; // tejarak
// set the call back is null to redirecto to default dash callback payment
self::$config['irkish']['revertURL']   = null;
self::$config['irkish']['description'] = 'tejarak.com';
self::$config['irkish']['paymentId']   = null;
self::$config['irkish']['sha1']        = '22338240992352910814917221751200141041845518824222260'; // main



?>