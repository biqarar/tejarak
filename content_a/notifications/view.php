<?php
namespace content_a\notifications;

class view
{

	public static function config()
	{
		\dash\data::notify(\content_a\notifications\model::get_notifications());
	}

}
?>