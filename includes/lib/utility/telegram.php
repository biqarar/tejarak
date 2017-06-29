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

	public static function config()
	{
		$url = 'http://178.62.218.8:8081/get_request_hook';
		$headers =
		[
			'app-name: tejarak',
			'content-type: application/json',
			'request-id: 0',
			'request-method: sendMessage',
			'telegram-id: 33263188',
		];

		$content =
		[
			'text'    => 'سلام رضا خوبی',
			'chat_id' => 33263188,
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
			// check mycode in special situation, if has default code with status handle it
			curl_close ($handle);
			//=====================================================================================//
			// for debug you can uncomment below line to see the result get from server
			// var_dump($response);
			var_dump($response);exit();
		}
		else
		{
			\lib\debug::warn(T_("Please install curl on your system"));
		}
	}
}
?>