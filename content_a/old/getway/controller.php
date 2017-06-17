<?php
namespace content_a\getway;

class controller extends \content_a\main\controller
{
	/**
	 * rout
 	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$this->get('listgetway', 'listgetway')->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway$/");

		// $this->get('listgetway', 'listgetway')->ALL(
		// [
		// 	// 'url'      => "/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway$/",
		// 	'url'      => "/.*/",
		// 	'property' =>
		// 	[
		// 		'search' => ["/^.*$/", true, 'search'],
		// 		'page'   => ["/^.*$/", true, 'page'],
		// 	],
		// ]);

		$this->get('addgetway', 'addgetway')	->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/add$/");

		$this->post('addgetway')			  	->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/add$/");

		if(
			preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/add$/", $url) ||
			preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/(\d+)\/edit$/", $url)
		  )
		{
			$this->display_name = 'content_a\getway\add_edit.html';
		}

		$this->get('editgetway', 'editgetway')	->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/(\d+)\/edit$/");
		$this->post('editgetway')			  			->ALL("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/(\d+)\/edit$/");
	}
}
?>