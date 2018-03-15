<?php
namespace content\contact;

class view extends \content\main\view
{
	function config()
	{
		$this->data->page['title'] = \lib\url::module();
		$this->data->bodyclass     = 'unselectable vflex';
	}
}
?>