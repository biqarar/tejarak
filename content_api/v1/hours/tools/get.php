<?php
namespace content_api\v1\hours\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	public $logo_urls = [];

	/**
	 * ready data of hours to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_hours($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_hours' => true,
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
					$result[$key] = \lib\utility\shortURL::encode($value);
					break;

				case 'status':
					// only enable hours can be show
					switch ($value)
					{
						case 'enable':
							$result[$key] = $value ? (string) $value : null;
							break;
						default:
							return false;
							break;
					}
					break;
				case 'name':
				case 'website':
				case 'desc':
				case 'alias':
				case 'privacy':
					$result[$key] = isset($value) ? (string) $value : null;
					break;
				case 'shortname':
					$result['short_name'] = $value ? (string) $value : null;
					break;
				case 'showavatar':
					$result['show_avatar'] = $value ? true : false;
					break;
				case 'allowplus':
					$result['allow_plus'] = $value ? true : false;
					break;
				case 'allowminus':
					$result['allow_minus'] = $value ? true : false;
					break;
				case 'remote':
					$result['remote_user'] = $value ? true : false;
					break;
				case '24h':
					$result['24h'] = $value ? true : false;
					break;

				case 'logourl':
					if($value)
					{
						$result['logo'] = $this->host('file'). '/'. $value;
					}
					else
					{
						$result['logo'] = null;
					}
					break;

				case 'logo':
					continue;
					if(isset($this->logo_urls[$value]))
					{
						$result['logo'] = $this->host('file'). '/'. $this->logo_urls[$value];
					}
					else
					{
						$result['logo'] = null;
					}
					break;

				case 'fileid':
				case 'creator':
				case 'telegram_id':
				case 'plan':
				case 'until':
				case 'createdate':
				case 'date_modified':
				case 'meta':
				case 'value':
				default:
					continue;
					break;
			}
		}
		return $result;
	}


	/**
	 * Gets the hours.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The hours.
	 */
	public function get_hours($_options = [])
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
			// return false;
		}

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			logs::set('api:hours:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("hours id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hours::access_hours_id($id, $this->user_id, ['action' => 'view']);

		if(!$result)
		{
			logs::set('api:hours:access:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to load this hours details"), 'hours', 'permission');
			return false;
		}

		debug::title(T_("Operation complete"));

		$result = $this->ready_hours($result);

		return $result;
	}
}
?>