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


	public function get_lesson_times(&$_data)
	{
		if(isset($_data['lesson_id']) && \lib\utility\shortURL::is($_data['lesson_id']))
		{
			$lesson_id = $_data['lesson_id'];
			$lesson_id = \lib\utility\shortURL::decode($lesson_id);

			$times = \lib\db\lessontimes::get_lessontime(['lesson_id' => $lesson_id]);

			// var_dump($times);

		}
		// var_dump($_data);exit();
	}

}
?>