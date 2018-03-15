<?php
namespace content_cp\teams\hours;


class model extends \mvc\model
{
	public function hours_list($_args, $_fields)
	{
		$team_id           = \lib\url::dir(2);

		$meta              = [];
		$meta['admin']     = true;
		$meta['team_id']   = $team_id;
		$meta['limit']     = 100;
		$meta['end_limit'] = 100;

		$url_property      = \lib\router::$url_array_property;

		foreach ($url_property as $key => $value)
		{
			if(preg_match("/\=/", $value))
			{
				$split = explode('=', $value);
				if($split[0] == 'page')
				{
					continue;
				}
				$meta[$split[0]] = $split[1];
			}
		}

		$search = null;
		if(\lib\utility::get('search'))
		{
			$search = \lib\utility::get('search');
		}

		$result = \lib\db\hourlogs::search($search, $meta);
		// var_dump($result);exit();
		return $result;
	}
}
?>
