<?php
namespace content_api\v1\company\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	/**
	 * ready data of company to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_company($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_company' => false,
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
					if($_options['check_is_my_company'])
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
	 * Gets the company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The company.
	 */
	public function get_list_company($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}
		$search = [];
		$search['boss'] = $this->user_id;
		$search['status'] = ['<>', "'deleted'"];
		$result = \lib\db\companies::search(null, $search);
		$temp = [];
		foreach ($result as $key => $value)
		{
			$temp[] = $this->ready_company($value, ['check_is_my_company' => true]);
		}

		return $temp;
	}


	/**
	 * Gets the company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The company.
	 */
	public function get_company($_options = [])
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

		$company = utility::request("company");

		if(!$company)
		{
			logs::set('api:company:not:found', $this->user_id, $log_meta);
			debug::error(T_("Invalid comany brand"), 'company', 'permission');
			return false;
		}

		debug::title(T_("Operation complete"));
		$result = \lib\db\companies::get_brand($company);

		$options =
		[
			'check_is_my_company' => true,
		];
		$result = $this->ready_company($result, $options);

		if($result === false)
		{
			logs::set('api:company:access:to:load', $this->user_id, $log_meta);
			debug::error(T_("You can not load this company"));
			return false;
		}
		return $result;
	}
}
?>