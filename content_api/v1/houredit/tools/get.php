<?php
namespace content_api\v1\houredit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	public $logo_urls = [];

	/**
	 * ready data of houredit to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_houredit($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_houredit' => true,
		];

		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($default_options, $_options);

		$result = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{
				case 'id':
				case 'hour_id':
					$result[$key] = \lib\utility\shortURL::encode($value);
					break;

				default:
					if($value)
					{
						$result[$key] = $value;
					}
					else
					{
						$result[$key] = null;
					}
					break;
			}

		}
		return $result;
	}


	/**
	 * Gets the houredit.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The houredit.
	 */
	public function get_houredit($_options = [])
	{
		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			logs::set('api:houredit:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::access_hourrequest_id($id, $this->user_id, ['action' => 'view']);

		if(!$result)
		{
			// logs::set('api:houredit:access:denide', $this->user_id, $log_meta);
			// debug::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		debug::title(T_("Operation complete"));

		$result = $this->ready_houredit($result);

		return $result;
	}
}
?>