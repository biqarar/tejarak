<?php
namespace content_api\v1\lesson\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait class_time
{
	public function class_time_check($_args = [])
	{
		$this->class_time_insert($_args);
	}


	/**
	 * insert data to
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function class_time_insert($_args = [])
	{
		$times = utility::request('times');
		if (!$times || !is_array($times))
		{
			return false;
		}

		$insert = [];

		foreach ($times as $key => $value)
		{
			if(!isset($value['week']) || !isset($value['start']) || !isset($value['end']))
			{
				continue;
			}

			if(!$value['week'] || !$value['start'] || !$value['end'])
			{
				continue;
			}

			if(!in_array($value['week'], ['sunday','monday','tuesday','wednesday','thursday','friday','saturday']))
			{
				continue;
			}

			$temp =
			[
				'school_id'     => $_args['school_id'],
				'place_id'      => $_args['place_id'],
				'schoolterm_id' => $_args['schoolterm_id'],
				'creator'       => $this->user_id,
				'weekday'       => $value['week'],
				'start'         => $value['start'],
				'end'           => $value['end'],
			];

			if($this->class_time_exist($temp))
			{
				continue;
			}

			$insert[] = $temp;
		}

		if(!empty($insert))
		{
			\lib\db\classtimes::multi_insert($insert);
		}

	}


	/**
	 * check time record exist or no
	 *
	 * @param      <type>   $_where  The where
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function class_time_exist($_where)
	{
		unset($_where['creator']);
		$_where['limit'] = 1;
		if(\lib\db\classtimes::get($_where))
		{
			return true;
		}
		return false;
	}

}
?>