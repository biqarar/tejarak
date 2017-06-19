<?php
namespace content_api\v1\hours\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait delete
{

	/**
	 * Gets the hours.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The hours.
	 */
	public function delete_hours($_args = [])
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
			logs::set('api:hours:delete:brand:not:set', $this->user_id, $log_meta);
			debug::error(T_("Brand not set"), 'brand', 'arguments');
			return false;
		}

		$where              = [];
		$where['boss']      = $this->user_id;
		$where['brand']     = $brand;
		$where['limit']     = 1;

		$result = \lib\db\hourss::get($where);
		if(isset($result['id']))
		{
			if(\lib\db\hourss::update(['status' => 'deleted'], $result['id']))
			{
				$log_meta['meta']['hours'] = $result;
				logs::set('api:hours:delete:hours:complete', $this->user_id, $log_meta);
				debug::title(T_("Operation Complete"));
			}
		}
		else
		{
			logs::set('api:hours:delete:brand:not:found', $this->user_id, $log_meta);
			debug::error(T_("Brand not found"), 'brand', 'arguments');
			return false;
		}
	}
}
?>