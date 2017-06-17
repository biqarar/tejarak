<?php
namespace content_enter\okay;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if this step is locked go to error page and return
		if(self::lock('okay'))
		{
			self::error_page('okay');
			return;
		}

	}
}
?>