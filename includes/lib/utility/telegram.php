<?php
namespace lib\utility;

class telegram
{
	/**
	* force send message by telegram service
	* not by hasan service :|
	*/
	private static $service_url                 = 'http://178.62.218.8:8081';
	private static $force_send_telegram_service = true;
	private static $telegram_api_url            = 'https://api.telegram.org/bot339018788:AAFg-KYxZ8yI-yU74qt1tq0DFNtLfT4Puv8';

	public static $SORT = [];

	/**
	 * send array messages
	 *
	 * @param      array  $_args  The arguments
	 */
	public static function tg_curl_group($_args = [])
	{
		$default_args =
		[
			'url'      => self::$service_url,
			'app_name' => 'tejarak',
			'content'  => null,
		];

		if(is_array($_args))
		{
			$_args = array_merge($default_args, $_args);
		}
		else
		{
			$_args = $default_args;
		}

		if(!$_args['url'] || !$_args['content'] || !$_args['app_name'])
		{
			return false;
		}

		$url = "$_args[url]/$_args[app_name]/sendArray";

		$headers =
		[
			"content-type: application/json",
		];

		$content = json_encode($_args['content'], JSON_UNESCAPED_UNICODE);

		self::curlExec($url, $headers, $content);
	}


	/**
	 * tg curl
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function tg_curl($_args = [])
	{
		$default_args =
		[
			'url'      => self::$service_url,
			'app_name' => 'tejarak',
			'method'   => 'sendMessage',
			'text'     => null,
			'chat_id'  => null,
		];

		if(is_array($_args))
		{
			$_args = array_merge($default_args, $_args);
		}
		else
		{
			$_args = $default_args;
		}

		if(!$_args['url'] || !$_args['method'] || !$_args['chat_id'] || !$_args['app_name'])
		{
			return false;
		}

		$url = "$_args[url]/$_args[app_name]/$_args[method]";

		$headers =
		[
			// "app-name: $_args[app_name]",
			"content-type: application/json",
			// "request-id: $_args[request_id]",
			// "request-method: $_args[method]",
			// "telegram-id: $_args[chat_id]",
		];

		if(!$_args['text'])
		{
			return false;
		}

		$content =
		[
			'text'    => $_args['text'],
			'chat_id' => $_args['chat_id'],
		];

		if(!$content['chat_id'])
		{
			return false;
		}

		$content = json_encode($content, JSON_UNESCAPED_UNICODE);

		self::curlExec($url, $headers, $content);
	}


	/**
	 * curl execut
	 *
	 * @param      <type>  $_url      The url
	 * @param      <type>  $_header   The header
	 * @param      <type>  $_content  The content
	 */
	private static function curlExec($_url, $_headers, $_content, $_option = [])
	{

		if(!function_exists('curl_init'))
		{
			\lib\db\logs::set('telegram:curl:not:install', null, ['meta' =>[]]);
			\lib\debug::warn(T_("Please install curl on your system"));
		}

		if(self::$force_send_telegram_service)
		{
			$array_content = json_decode($_content, true);
			if(preg_match("/sendArray/", $_url))
			{
				foreach ($array_content as $key => $value)
				{
					if(isset($value['method']))
					{
						$_url = self::$telegram_api_url . '/'. $value['method'];
						$handle   = curl_init();
						curl_setopt($handle, CURLOPT_URL, $_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $_headers);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_POST, true);
						curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($value, JSON_UNESCAPED_UNICODE));
						curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
						curl_setopt($handle, CURLOPT_TIMEOUT, 20  );

						$response = curl_exec($handle);
						$mycode   = curl_getinfo($handle, CURLINFO_HTTP_CODE);

						curl_close ($handle);

						\lib\db\logs::set("telegram:service:curl", null, ['meta' => ['response' => $response, 'http_code' => $mycode, 'args' => func_get_args()]]);
					}
				}
			}
			else
			{
				if(isset($array_content['method']))
				{
					$_url = self::$telegram_api_url . '/'. $array_content['method'];
					$handle   = curl_init();
					curl_setopt($handle, CURLOPT_URL, $_url);
					curl_setopt($handle, CURLOPT_HTTPHEADER, $_headers);
					curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($handle, CURLOPT_POST, true);
					curl_setopt($handle, CURLOPT_POSTFIELDS, $_content);
					curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
					curl_setopt($handle, CURLOPT_TIMEOUT, 20  );

					$response = curl_exec($handle);
					$mycode   = curl_getinfo($handle, CURLINFO_HTTP_CODE);

					curl_close ($handle);

					\lib\db\logs::set("telegram:service:curl", null, ['meta' => ['response' => $response, 'http_code' => $mycode, 'args' => func_get_args()]]);
				}
			}
		}
		else
		{
			$handle   = curl_init();
			curl_setopt($handle, CURLOPT_URL, $_url);
			curl_setopt($handle, CURLOPT_HTTPHEADER, $_headers);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, $_content);
			curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($handle, CURLOPT_TIMEOUT, 20  );

			$response = curl_exec($handle);
			$mycode   = curl_getinfo($handle, CURLINFO_HTTP_CODE);

			curl_close ($handle);

			\lib\db\logs::set("telegram:curl", null, ['meta' => ['response' => $response, 'http_code' => $mycode, 'args' => func_get_args()]]);
		}
	}


	/**
	 * Sends a message via telegram
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function sendMessage($_chat_id, $_text, $_option = [])
	{
		$default_option =
		[
			'sort' => null,
		];

		if(!$_chat_id)
		{
			return false;
		}

		if(is_array($_option))
		{
			$_option = array_merge($default_option, $_option);
		}

		$args =
		[
			'parse_mode' => 'html',
			'method'     => 'sendMessage',
			'chat_id'    => $_chat_id,
			'text'       => $_text,
		];

		if($_option['sort'])
		{
			self::$SORT[] = ['sort' => $_option['sort'], 'curl' => $args];
		}
		else
		{
			return self::tg_curl($args);
		}
	}



	/**
	 * Sends a message via telegram
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function sendMessageGroup($_chat_id, $_text, $_option = [])
	{
		if(!$_chat_id)
		{
			return false;
		}

		$default_option =
		[
			'sort' => null,
		];

		if(is_array($_option))
		{
			$_option = array_merge($default_option, $_option);
		}

		$args =
		[
			'parse_mode' => 'html',
			'method'     => 'sendMessage',
			'chat_id'    => $_chat_id,
			'text'       => $_text,
		];

		if($_option['sort'])
		{
			self::$SORT[] = ['sort' => $_option['sort'], 'curl' => $args];
		}
		else
		{
			return self::tg_curl($args);
		}
	}


	/**
	* send message as sort
	*/
	public static function sort_send()
	{

		if(!empty(self::$SORT))
		{
			$sort = array_column(self::$SORT, 'sort');
			array_multisort($sort,SORT_ASC, self::$SORT);
			self::$SORT = array_filter(self::$SORT);
			$curl_group = array_column(self::$SORT, 'curl');

			self::tg_curl_group(['content' => $curl_group]);

			// foreach (self::$SORT as $key => $value)
			// {
			// 	if(isset($value['curl']))
			// 	{
			// 		self::tg_curl($value['curl']);
			// 	}
			// }
		}
	}

	/**
	* clear cashed meessage
	*/
	public static function clean_cash()
	{
		self::$SORT = [];
	}
}
?>