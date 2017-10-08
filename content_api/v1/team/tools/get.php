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
				case 'creator':
				// case 'parent':
					if(isset($value))
					{
						$result[$key] = \lib\utility\shortURL::encode($value);
					}
					else
					{
						$result[$key] = null;
					}
					break;

				case 'desc2':
					$result['address'] = $value ? (string) $value : null;
					break;

				case 'type':

					if($value === 'classroom')
					{
						if(isset($_data['desc3']))
						{
							$result['multi_classroom'] = $_data['desc3'] ? true : false;
						}
						if(isset($_data['desc4']))
						{
							$result['classroom_size'] = isset($_data['desc4']) ? $_data['desc4'] : null;
						}
					}
					else
					{
						if(isset($_data['desc3']))
						{
							$result['awards'] = isset($_data['desc3']) ? $_data['desc3'] : null;
						}

						if(isset($_data['desc4']))
						{
							$result['about'] = isset($_data['desc4']) ? $_data['desc4'] : null;
						}
					}
					break;

				case 'phone1':
					$result['tel'] = $value ? (string) $value : null;
					break;
				case 'phone2':
					$result['fax'] = $value ? (string) $value : null;
					break;

				// case 'status':
					// only enable team can be show
					// switch ($value)
					// {
					// 	case 'enable':
					// 	case 'close':
					// 		$result[$key] = $value ? (string) $value : null;
					// 		break;
					// 	default:
					// 		return false;
					// 		break;
					// }
					// break;

				case 'country':
				case 'city':
				case 'province':
				case 'zipcode':
				case 'name':
				case 'website':
				case 'desc':
				case 'alias':
				case 'status':
				case 'privacy':
				case 'rule':
				case 'gender':
					$result[$key] = isset($value) ? (string) $value : null;
					break;
				case 'shortname':
					$result['short_name'] = $value ? (string) $value : null;
					$result['url'] = $this->host('with_language'). '/'. $value;
					break;

				case 'lang':
					$result['language'] = isset($value) ? (string) $value : null;
					break;

				case 'manualtimeenter':
					$result['manual_time_enter'] = $value ? true : false;
					break;

				case 'manualtimeexit':
					$result['manual_time_exit'] = $value ? true : false;
					break;

				case 'sendphoto':
					$result['send_photo'] = $value ? true : false;
					break;

				case 'eventtitle':
					$result['event_title'] = isset($value) ? $value : null;
					break;

				case 'eventdate':
				case 'eventenddate':
					$myKey = $key === 'eventenddate' ? 'event_date' : 'event_date_start';
					if($value)
					{
						$strtotime            = strtotime($value);
						$result[$myKey] = date("Y-m-d", $strtotime);
						$toGregorian          = \lib\utility\jdate::toGregorian(date("Y", $strtotime), date("m", $strtotime), date("d", $strtotime));
					 	if(is_array($toGregorian))
					 	{
							$result[$myKey. '_gregorian'] = implode('-', $toGregorian);
					 	}
					}
					else
					{
						$result[$myKey] = null;
					}
					break;

				case 'showavatar':
					$result['show_avatar'] = $value ? true : false;
					break;
				case 'allowplus':
					$result['allow_plus'] = $value ? true : false;
					break;

				case 'quick':
					$result['quick_traffic'] = $value ? true : false;
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
						$result['logo'] = $this->host('siftal_image');
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
				case 'cardsize':
					$result['cardsize'] = $value ? intval($value) : null;
					break;

				case 'allowdescenter':
					$result['allow_desc_enter'] = $value ? true : false;
					break;

				case 'allowdescexit':
					$result['allow_desc_exit'] = $value ? true : false;
					break;

				case 'fileid':
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

		if(isset($result['event_date_start_gregorian']) && isset($result['event_date_gregorian']))
		{
			$now                        = date("Y-m-d");
			$start                      = $result['event_date_start_gregorian'];
			$end                        = $result['event_date_gregorian'];

			$datenow                    = new \DateTime("now");
			$dateevent                  = new \DateTime($end);
			$dateend                    = new \DateTime($start);
			$interval                   = $dateevent->diff($datenow);
			$diff                       = $dateevent->diff($dateend)->days;
			$result['event']            = [];
			$result['event']['days']    = $diff;
			$result['event']['left']    = $interval->days;


			if($datenow < $dateevent)
			{
				$result['event']['remain'] = $interval->days;
			}
			else
			{
				$result['event']['remain'] = $interval->days * (-1);
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
					$meta       = array_column($get_post_record, 'meta');
					$url             = array_column($meta, 'url');
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

		$meta = [];

		$type = utility::request('type');
		if($type && !is_string($type))
		{
			logs::set('api:team:get:list:type:invalid', $this->user_id);
			debug::error(T_("Invalid team type"), 'type', 'arguments');
			return false;
		}

		$meta['type'] = $type;

		$result = \lib\db\teams::team_list($this->user_id, $meta);
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
			if($id)
			{
				$result = \lib\db\teams::get(['id' => $id, 'limit' => 1]);
			}
			elseif($shortname)
			{
				$result = \lib\db\teams::get(['shortname' => $shortname, 'limit' => 1]);
			}

			if($result)
			{
				if(\lib\permission::access('load:all:team', null, $this->user_id))
				{
					$result = $result;
				}
				else
				{
					\lib\temp::set('team_access_denied', true);
					\lib\temp::set('team_exist', true);
					$result = false;
				}
			}
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