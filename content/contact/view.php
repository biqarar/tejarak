<?php
namespace content\contact;

class view extends \content\main\view
{
	function config()
	{
		$this->data->page['title'] = \dash\url::module();
		$this->data->bodyclass     = 'unselectable vflex';
	}
}
?>