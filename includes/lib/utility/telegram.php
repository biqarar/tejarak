<?php
namespace lib\utility;

class telegram
{

// curl -X POST \
//   http://178.62.218.8:8081/get_request_hook \
//   -H 'app-name: tejarak' \
//   -H 'content-type: application/json' \
//   -H 'request-id: 0' \
//   -H 'request-method: sendMessage' \
//   -H 'telegram-id: 33263188' \
//   -d '{
//     "text" : "hi",
//     "chat_id" : 33263188
//   }'

	public static function tg_curl($_args = [])
	{
		$default_args =
		[
			'url'            => 'http://178.62.218.8:8081/get_request_hook',
			'app_name'       => 'tejarak',
			'request_method' => 'sendMessage',
			'telegram_id'    => null,
			'request_id'     => 0,
			'text'           => null,
			'file'           => null,
			'telegram_group' => null,
		];

		if(is_array($_args))
		{
			$_args = array_merge($default_args, $_args);
		}

		$url = $_args['url'];

		if(!$_args['url'] || !$_args['request_method'] || !$_args['telegram_id'] || !$_args['app_name'])
		{
			return false;
		}

		$headers =
		[
			"app-name: $_args[app_name]",
			"content-type: application/json",
			"request-id: $_args[request_id]",
			"request-method: $_args[request_method]",
			"telegram-id: $_args[telegram_id]",
		];

		$content =
		[
			'text'    => $_args['text'],
			'chat_id' => $_args['telegram_group'],
		];

		$content = json_encode($content, JSON_UNESCAPED_UNICODE);

		if(function_exists('curl_init'))
		{
			$handle   = curl_init();
			curl_setopt($handle, CURLOPT_URL, $url);
			curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, $content);
			// add timer to ajax request
			curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($handle, CURLOPT_TIMEOUT, 20  );

			$response = curl_exec($handle);
			$mycode   = curl_getinfo($handle, CURLINFO_HTTP_CODE);

			curl_close ($handle);

			\lib\db\logs::set("telegram:curl:$_args[request_method]", null, ['meta' => ['response' => $response, 'http_code' => $mycode]]);
		}
		else
		{
			\lib\db\logs::set('telegram:curl:not:install', null, ['meta' =>[]]);
			\lib\debug::warn(T_("Please install curl on your system"));
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
	public static function sendMessage($_chat_id, $_text)
	{
		$args =
		[
			'request_method' => 'sendMessage',
			'telegram_id'    => $_chat_id,
			'telegram_group' => $_chat_id,
			'text'           => $_text,
		];
		return self::tg_curl($args);
	}



	/**
	 * Sends a message via telegram
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function sendMessageGroup($_chat_id, $_text)
	{
		$args =
		[
			'request_method' => 'sendMessage',
			'telegram_id'    => 33263188,
			'telegram_group' => $_chat_id,
			'text'           => $_text,
		];
		return self::tg_curl($args);
	}
}
?>