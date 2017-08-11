<?php
namespace content_api\v1\team\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	public $logo_urls = [];

	/**
	 * ready data of team to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_team($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_team' => true,
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
					// only enable team can be show
					switch ($value)
					{
						case 'enable':
						case 'close':
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
				case 'rule':
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
	 * Loads file records.
	 *
	 * @param      <type>  $_result  The result
	 */
	public function load_file_records($_result)
	{
		if(is_array($_result))
		{
			$logos = array_column($_result, 'logo');
			$logos = array_filter($logos);
			$logos = array_unique($logos);
			if(!empty($logos))
			{
				$get_post_record = \lib\db\posts::get_some_id($logos);
				if(!empty($get_post_record))
				{
					$id              = array_column($get_post_record, 'id');
					$post_meta       = array_column($get_post_record, 'post_meta');
					$url             = array_column($post_meta, 'url');
					$this->logo_urls = array_combine($id, $url);
				}
			}
		}
	}

	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function get_list_team($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}

		$result = \lib\db\teams::team_list($this->user_id);
		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = $this->ready_team($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		return $temp;
	}


	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function get_list_team_child($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}
	}

	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function get_team($_options = [])
	{
		$default_options =
		[
			'debug' => true,
		];

		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($default_options, $_options);

		if($_options['debug'])
		{
			debug::title(T_("Operation Faild"));
		}

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

		$shortname = utility::request('shortname');

		if(!$id && !$shortname)
		{
			if($_options['debug'])
			{
				logs::set('api:team:id:shortname:not:set', $this->user_id, $log_meta);
				debug::error(T_("Team id or shortname not set"), 'id', 'arguments');
			}
			return false;
		}

		if($id && $shortname)
		{
			logs::set('api:team:id:shortname:together:set', $this->user_id, $log_meta);
			if($_options['debug'])
			{
				debug::error(T_("Can not set team id and shortname together"), 'id', 'arguments');
			}
			return false;
		}

		if($id)
		{
			$result = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'view']);
		}
		else
		{
			$result = \lib\db\teams::access_team($shortname, $this->user_id, ['action' => 'view']);
		}

		if(!$result)
		{
			logs::set('api:team:access:denide', $this->user_id, $log_meta);
			if($_options['debug'])
			{
				debug::error(T_("Can not access to load this team details"), 'team', 'permission');
			}
			return false;
		}

		if($_options['debug'])
		{
			debug::title(T_("Operation complete"));
		}

		$result = $this->ready_team($result);

		return $result;
	}
}
?>