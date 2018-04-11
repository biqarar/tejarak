<?php
namespace lib\app\hours;


trait get
{
	public static $logo_urls = [];

	/**
	 * ready data of hours to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready_hours($_data, $_options = [])
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
				case 'start_gateway_id':
				case 'end_gateway_id':
					$result[$key] = \dash\coding::encode($value);
					break;

				case 'date':
				case 'year':
				case 'month':
				case 'day':
				case 'shamsi_date':
				case 'shamsi_year':
				case 'shamsi_month':
				case 'shamsi_day':
				case 'start':
				case 'end':
				case 'diff':
				case 'minus':
				case 'plus':
				case 'type':
				case 'accepted':
				case 'total':
				case 'status':
				case 'enddate':
				case 'endyear':
				case 'endmonth':
				case 'endday':
				case 'endshamsi_date':
				case 'endshamsi_year':
				case 'endshamsi_month':
				case 'endshamsi_day':

					if($value)
					{
						$result[$key] = $value;
					}
					else
					{
						$result[$key] = null;
					}
					break;

				case 'desc':
					$result['desc_enter'] = isset($value) ? $value : null;
					break;

				case 'desc2':
					$result['desc_exit'] = isset($value) ? $value : null;
					break;

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
	public static function get_hours($_options = [])
	{
		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		if(!\dash\user::id())
		{
			// return false;
		}

		$id = \dash\app::request("id");
		$id = \dash\coding::decode($id);

		if(!$id)
		{
			\dash\db\logs::set('api:hours:id:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("hours id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hours::access_hours_id($id, \dash\user::id(), ['action' => 'view']);

		if(!$result)
		{
			\dash\db\logs::set('api:hours:access:denide', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Can not access to load this hours details"), 'hours', 'permission');
			return false;
		}

		// \dash\notif::title(T_("Operation complete"));

		$result = self::ready_hours($result);

		return $result;
	}
}
?>