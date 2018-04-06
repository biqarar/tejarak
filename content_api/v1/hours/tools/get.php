<?php
namespace content_api\v1\hours\tools;


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
				case 'start_gateway_id':
				case 'end_gateway_id':
					$result[$key] = \lib\coding::encode($value);
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
	public function get_hours($_options = [])
	{
		// \lib\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			// return false;
		}

		$id = \lib\utility::request("id");
		$id = \lib\coding::decode($id);

		if(!$id)
		{
			\dash\db\logs::set('api:hours:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("hours id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hours::access_hours_id($id, $this->user_id, ['action' => 'view']);

		if(!$result)
		{
			\dash\db\logs::set('api:hours:access:denide', $this->user_id, $log_meta);
			\lib\notif::error(T_("Can not access to load this hours details"), 'hours', 'permission');
			return false;
		}

		// \lib\notif::title(T_("Operation complete"));

		$result = $this->ready_hours($result);

		return $result;
	}
}
?>