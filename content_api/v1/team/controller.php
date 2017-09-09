<?php
namespace content_api\v1\team;

class controller extends \addons\content_api\home\controller
{

	public function _route()
	{
		$this->get('teamList')->ALL('v1/team/list');

		$this->post('setTelegramGroup')->ALL('v1/team/telegram/group');

		$this->get('one_team')->ALL('v1/team');
	}
}
?>