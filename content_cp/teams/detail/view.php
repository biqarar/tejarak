<?php
namespace content_cp\teams\detail;

class view
{
	public static function config()
	{

		$id = \dash\request::get('id');
		$result = [];
		if($id && is_numeric($id))
		{
			$result = \lib\db\teams::get(['id' => $id, 'limit' => 1]);
		}

		\dash\data::userRecord($result);
	}
}
?>