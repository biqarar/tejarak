<?php
namespace content_a\ref;

class controller extends  \content_a\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get(false, 'ref')->ALL();
	}
}
?>