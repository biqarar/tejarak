<?php
namespace content_cp\teamplans;

use \lib\utility;
use \lib\debug;
class model extends \mvc\model
{
	public function teamplans_list($_args, $_fields = [])
	{
		$meta   = [];

		$search = null;
		if(utility::get('search'))
		{
			$search = utility::get('search');
		}

		foreach ($_fields as $key => $value)
		{
			if(isset($_args->get($value)[0]))
			{
				$meta[$value] = $_args->get($value)[0];
			}
		}

		if(empty($meta))
		{
			$meta['teamplans.status'] = 'enable';
			$meta['sort']             = 'teamplans.lastcalcdate';
			$meta['order']            = 'desc';
		}

		$meta['admin'] = true;


		$result = \lib\db\teamplans::search($search, $meta);
		if(is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if(isset($value['plan']))
				{
					$result[$key]['plan'] = \lib\utility\plan::plan_name($value['plan']);
				}
				if(isset($value['lastcalcdate']))
				{
					$renew_time = strtotime("+30 day") - strtotime($value['lastcalcdate']);
					$renew_time = date("d", $renew_time). ' '. T_("Day"). ' '. T_("And"). ' '. date("H", $renew_time). " ". T_("Hour");
					$result[$key]['renew_time'] = $renew_time;
				}
			}
		}

		return $result;
	}
}
?>
