<?php
namespace content_cp\teams;


class model extends \mvc\model
{
	public function teams_list($_args, $_fields = [])
	{
		$meta   = [];
		$meta['admin'] = true;

		$search = null;
		if(\dash\request::get('search'))
		{
			$search = \dash\request::get('search');
		}

		foreach ($_fields as $key => $value)
		{
			if(isset($_args->get($value)[0]))
			{
				$meta[$value] = $_args->get($value)[0];
			}
		}

		$result = \lib\db\teams::search($search, $meta);
		// var_dump($result);exit();
		return $result;
	}
}
?>
