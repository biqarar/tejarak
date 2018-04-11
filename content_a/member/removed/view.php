<?php
namespace content_a\member\removed;

class view
{
	public static function config()
	{
		$request           = [];
		$request['status'] = 'suspended';
		$request['id']     = \dash\request::get('id');
		\dash\app::variable($request);
		$result =  \lib\app\member::get_list_member();
		\dash\data::listMember($result);
	}

}
?>