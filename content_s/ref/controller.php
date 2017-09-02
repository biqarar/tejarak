<?php
namespace content_s\ref;

class controller extends  \content_s\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get(false, 'ref')->ALL();
	}
}
?>