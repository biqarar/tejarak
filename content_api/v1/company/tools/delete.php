<?php
namespace content_api\v1\company\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait delete
{

	/**
	 * Gets the company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The company.
	 */
	public function delete_company($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}

		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		$brand = utility::request("brand");

		if(!$brand)
		{
			logs::set('api:company:delete:brand:not:set', $this->user_id, $log_meta);
			debug::error(T_("Brand not set"), 'brand', 'arguments');
			return false;
		}

		$where              = [];
		$where['boss']      = $this->user_id;
		$where['brand']     = $brand;
		$where['limit']     = 1;

		$result = \lib\db\companies::get($where);
		if(isset($result['id']))
		{
			if(\lib\db\companies::update(['status' => 'deleted'], $result['id']))
			{
				$log_meta['meta']['company'] = $result;
				logs::set('api:company:delete:company:complete', $this->user_id, $log_meta);
				debug::title(T_("Operation Complete"));
			}
		}
		else
		{
			logs::set('api:company:delete:brand:not:found', $this->user_id, $log_meta);
			debug::error(T_("Brand not found"), 'brand', 'arguments');
			return false;
		}
	}
}
?>