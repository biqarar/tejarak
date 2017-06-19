<?php
namespace content_api\v1\hours\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
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
				case 'register_code':
				case 'economical_code':
					$result[$key] = (int) $value;
					break;

				case 'status':
				case 'title':
				case 'site':
				case 'brand':
					$result[$key] = (string) $value;
					break;

				case 'boss':
					if($_options['check_is_my_hours'])
					{
						if(intval($value) === intval($this->user_id))
						{
							// no problem
						}
						else
						{
							return false;
						}
					}
					break;

				case 'file_id':
				case 'logo':
				case 'creator':
				case 'technical':
				case 'telegram_id':
				case 'alias':
				case 'plan':
				case 'until':
				case 'createdate':
				case 'date_modified':
				case 'desc':
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
	public function get_list_hours($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}
		$search = [];
		$search['boss'] = $this->user_id;
		$search['status'] = ['<>', "'deleted'"];
		$result = \lib\db\hourss::search(null, $search);
		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = $this->ready_hours($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		return $temp;
	}


	/**
	 * Gets the hours.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The hours.
	 */
	public function get_list_hours_child($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}
		$search = [];
		$result = \lib\db\hourss::hours_child($this->user_id);
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
			return false;
		}

		$hours = utility::request("hours");

		if(!$hours)
		{
			logs::set('api:hours:not:found', $this->user_id, $log_meta);
			debug::error(T_("Invalid hours brand"), 'hours', 'permission');
			return false;
		}

		debug::title(T_("Operation complete"));
		$result = \lib\db\hourss::get_brand($hours);

		$options =
		[
			'check_is_my_hours' => true,
		];
		$result = $this->ready_hours($result, $options);

		if($result === false)
		{
			logs::set('api:hours:access:to:load', $this->user_id, $log_meta);
			debug::error(T_("You can not load this hours"));
			return false;
		}
		return $result;
	}
}
?>