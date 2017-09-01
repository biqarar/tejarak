<?php
namespace content_school\ref;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get(false, 'ref')->ALL();
	}
}
?>