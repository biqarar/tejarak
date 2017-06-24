<?php
namespace content_a\main;

class view extends \mvc\view
{
	public function config()
	{
		$this->data->bodyclass            = 'fixed unselectable dash';
		$this->data->template['teamLink'] = 'content_a\\main\\teamLink.html';
		$this->data->team                 = \lib\router::get_url(0);

	}
}
?>