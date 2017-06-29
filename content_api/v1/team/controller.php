<?php
namespace content_api\v1\team;

class controller extends \mvc\controller
{

	public function _route()
	{
		$this->get('teamList')->ALL('v1/team/list');
	}
}
?>