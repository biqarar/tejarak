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
		$this->classes_time_id = array_filter($this->classes_time_id);
		$this->classes_time_id = array_unique($this->classes_time_id);

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

		// get the id of calasses time
		foreach ($insert as $key => $value)
		{
			$this->class_time_exist($value);
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
		$check = \lib\db\classtimes::get($_where);
		if(isset($check['id']))
		{
			$this->classes_time_id[] = $check['id'];
			return true;
		}
		return false;
	}



	/**
	 * Gets the lesson times.
	 *
	 * @param      <type>  $_data  The data
	 */
	public function get_lesson_times(&$_data)
	{
		if(isset($_data['lesson_id']) && \lib\utility\shortURL::is($_data['lesson_id']))
		{
			$lesson_id = $_data['lesson_id'];
			$lesson_id = \lib\utility\shortURL::decode($lesson_id);

			$times = \lib\db\lessontimes::get_lessontime(['lesson_id' => $lesson_id]);

			$temp = [];

			if($times && is_array($times))
			{
				foreach ($times as $key => $value)
				{
					if(isset($value['weekday']) && isset($value['start']) && isset($value['end']) && isset($value['lessontime_status']) && $value['lessontime_status'] === 'enable')
					{
						$temp[] =
						[
							'week'  => $value['weekday'],
							'start' => $value['start'],
							'end'   => $value['end'],
						];
					}
				}
			}
			$_data['times'] = $temp;
		}

	}


	/**
	 * update
	 *
	 * @param      <type>  $_args         The arguments
	 * @param      <type>  $_lesson_data  The lesson data
	 */
	public function class_time_update($_args, $_lesson_data)
	{
		$times = \lib\db\lessontimes::get_lessontime(['lesson_id' => $_lesson_data['id']]);
		if(is_array($times))
		{
			$old_times = array_column($times, 'id');
		}

		$new_times = $this->classes_time_id;

		$must_insert = [];
		$must_remove = [];

		foreach ($new_times as $key => $value)
		{
			if(!in_array($value, $old_times))
			{
				$must_insert[] = $value;
			}
		}

		foreach ($old_times as $key => $value)
		{
			if(!in_array($value, $new_times))
			{
				$must_remove[] = $value;
			}
		}

		if(!empty($must_insert))
		{
			$insert_lesson_time = [];
			foreach ($must_insert as $key => $value)
			{
				$insert_lesson_time[] =
				[
					'lesson_id'    => $_lesson_data['id'],
					'classtime_id' => $value,
					'creator'      => $this->user_id,
				];
			}

			if(!empty($insert_lesson_time))
			{
				\lib\db\lessontimes::multi_insert($insert_lesson_time);
			}
		}

		if(!empty($must_remove))
		{
			foreach ($must_remove as $key => $value)
			{
				$temp =
				[
					'lesson_id'    => $_lesson_data['id'],
					'classtime_id' => $value,
				];
				\lib\db\lessontimes::remove($temp);
			}
		}

	}

}
?>