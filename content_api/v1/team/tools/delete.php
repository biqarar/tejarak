<?php
namespace content_api\v1\team\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait delete
{

	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function delete_team($_args = [])
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
			logs::set('api:team:delete:brand:not:set', $this->user_id, $log_meta);
			debug::error(T_("Brand not set"), 'brand', 'arguments');
			return false;
		}

		$where              = [];
		$where['boss']      = $this->user_id;
		$where['brand']     = $brand;
		$where['limit']     = 1;

		$result = \lib\db\teams::get($where);
		if(isset($result['id']))
		{
			if(\lib\db\teams::update(['status' => 'deleted'], $result['id']))
			{
				$log_meta['meta']['team'] = $result;
				logs::set('api:team:delete:team:complete', $this->user_id, $log_meta);
				debug::title(T_("Operation Complete"));
			}
		}
		else
		{
			logs::set('api:team:delete:brand:not:found', $this->user_id, $log_meta);
			debug::error(T_("Brand not found"), 'brand', 'arguments');
			return false;
		}
	}
}
?>