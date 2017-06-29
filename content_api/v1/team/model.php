<?php
namespace content_api\v1\team;

class model extends \content_api\v1\home\model
{
	use tools\add;
	use tools\get;
	use tools\delete;


	public function get_teamList()
	{
		return $this->get_list_team();
	}
}
?>