<?php
namespace content_api\v1\doc;

class controller extends  \mvc\controller
{
	public function __construct()
	{
		parent::__construct();
		\lib\temp::set('api', false);
	}

	public function _route()
	{
		$this->get(false,false)->ALL("/.*/");
	}
}
?>