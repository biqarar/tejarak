<?php
namespace content_a\main;

class view extends \mvc\view
{
	public function config()
	{
		$this->data->bodyclass = 'fixed unselectable dash';
	}
}
?>