<?php
namespace content_a\ref;

class controller extends  \content_a\main\controller
{

	public function ready()
	{

		$this->get(false, 'ref')->ALL();
	}
}
?>