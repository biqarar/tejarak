<?php
class cronjob
{
	public function _curl($_requests)
	{
		$handle   = curl_init();
		curl_setopt($handle, CURLOPT_URL, $_requests['url']);
		// curl_setopt($handle, CURLOPT_HTTPHEADER, json_encode($_requests['header'], JSON_UNESCAPED_UNICODE));
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, true);

		curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($_requests['header'], JSON_UNESCAPED_UNICODE));
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($handle, CURLOPT_TIMEOUT, 3);

		if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4'))
		{
 			curl_setopt($handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		}

		$response = curl_exec($handle);
		$mycode   = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		echo "$mycode \n";
		curl_close ($handle);
	}

	/**
	 * { function_description }
	 */
	public function requests()
	{
		$requests   = [];
		$requests[] = ['url' => 'https://tejarak.com/cronjob/pinger', 'header' => []];
		$requests[] = ['url' => 'https://tejarak.com/cronjob/report', 'header' => []];
		$requests[] = ['url' => 'https://tejarak.com/cronjob/notification', 'header' => []];
		$requests[] = ['url' => 'https://tejarak.com/cronjob/calc', 'header' => []];

		// $requests[] = ['url' => 'http://tejarak.dev/cronjob/report', 'header' => []];
		// $requests[] = ['url' => 'http://tejarak.dev/cronjob/calc', 'header' => []];
		// $requests[] = ['url' => 'http://tejarak.dev/cronjob/notification', 'header' => []];
		// $requests[] = ['url' => 'http://tejarak.dev/cronjob/pinger', 'header' => []];

		return $requests;
	}

	public function run()
	{
		foreach ($this->requests() as $key => $value)
		{
			$this->_curl($value);
		}
	}
}

(new cronjob)->run();

?>