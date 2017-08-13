<?php
namespace lib\db\teams;
trait active_deactive_member
{

	/**
	 * chashed data to not load again
	 *
	 * @var        array
	 */
	public static $CASH = [];


	/**
	 * Gets the member api.
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function get_member($_team_id)
	{

		if(!isset(self::$CASH[$_team_id]))
		{

			$where              = [];
			$where['team_id']   = $_team_id;
			$where['get_hours'] = true;
			$where['status']    = ['IN', "('active', 'deactive')"];
			$where['rule']      = ['IN', "('user', 'admin')"];
			$result             = \lib\db\userteams::get_list($where);

			$temp = [];
			foreach ($result as $key => $value)
			{
				if($ready = self::ready_member($value))
				{
					$temp[] = $ready;
				}
			}
			self::$CASH[$_team_id] = $temp;
		}
		return self::$CASH[$_team_id];
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function get_active_member($_team_id)
	{
		$resutl = self::get_member($_team_id);
		$temp = [];
		foreach ($resutl as $key => $value)
		{
			if(array_key_exists('last_time', $value))
			{
				if($value['last_time'])
				{
					$temp[] = $value;
				}
			}
		}
		return $temp;
	}

	/**
	 * Gets the deactive member.
	 *
	 * @param      <type>  $_team_id  The team identifier
	 *
	 * @return     <type>  The deactive member.
	 */
	public static function get_deactive_member($_team_id)
	{
		$resutl = self::get_member($_team_id);
		$temp = [];
		foreach ($resutl as $key => $value)
		{
			if(array_key_exists('last_time', $value))
			{
				if(!$value['last_time'])
				{
					$temp[] = $value;
				}
			}
		}
		return $temp;
	}




	/**
	 * ready data of member to load in api result
	 *
	 * @param      <type>  $_data     The data
	 * @param      array   $_options  The options
	 *
	 * @return     array   ( description_of_the_return_value )
	 */
	public static function ready_member($_data, $_options = [])
	{
		$default_options =
		[
			'condition_checked' => false,
			'inside_method'     => null,
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
				case 'status':
					if($value !== 'active')
					{
						return false;
					}
					break;
				case '24h':
					$result['24h'] = $value ? true : false;
					if(array_key_exists('date', $_data) && array_key_exists('start', $_data) && array_key_exists('end', $_data))
					{
						// the user is 24h
						if($value)
						{
							if($_data['end'])
							{
								$result['last_time_end'] = $_data['end'];
								$result['last_time'] = null;
							}
							else
							{
								$result['last_time'] = $_data['start'];
							}
						}
						else
						{
							if($_data['end'])
							{
								$result['last_time_end'] = $_data['end'];
								$result['last_time'] = null;
							}
							else
							{
								if($_data['date'] == date("Y-m-d"))
								{
									$result['last_time'] = $_data['start'];
								}
								else
								{
									$result['last_time'] = null;
								}
							}
						}
					}
					break;
				default:
					$result[$key] = $value;
					break;
			}
		}
		// krsort($result);
		return $result;
	}
}
?>