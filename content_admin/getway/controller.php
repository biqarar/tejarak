<?php
namespace content_admin\getway;

class controller extends \content_admin\main\controller
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

		if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/add$/", $url))
		{
			$this->display_name = 'content_admin\getway\add_edit.html';
		}

		// $this->get('getwaydashboard', 'getwaydashboard')		->ALL("/^([A-Za-z0-9]{5,})\/([^getway][A-Za-z0-9]{5,})$/");

		// $this->get('editgetway_company', 'editgetway_company')	->ALL("/^([A-Za-z0-9]{5,})\/getway\/(\d+)\/edit$/");

		// $this->post('editgetway_company')			  			->ALL("/^([A-Za-z0-9]{5,})\/getway\/(\d+)\/edit$/");

		// $this->post('getwaydashboard')			        		->ALL("/^([A-Za-z0-9]{5,})\/([^getway][A-Za-z0-9]{5,})$/");

		// if(preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})$/", \lib\router::get_url(), $split))
		// {
		// 	if(isset($split[2]) && $split[2] === 'getway')
		// 	{
		// 	}
		// 	else
		// 	{
		// 		$this->display_name = 'content_admin\getway\dashboard.html';
		// 	}
		// }

		// if(
		// 	preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/edit$/", \lib\router::get_url()) ||
		// 	preg_match("/^([A-Za-z0-9]{5,})\/getway\/add$/", \lib\router::get_url()) ||
		// 	preg_match("/^([A-Za-z0-9]{5,})\/([A-Za-z0-9]{5,})\/getway\/add$/", \lib\router::get_url()))
		// {
		// 	$this->display_name = 'content_admin\getway\add.html';
		// }

		// $this->get('listgetway', 'listgetway')						->ALL("/^([A-Za-z0-9]{5,})$/");
		// $this->get('listgetway', 'listgetway')						->ALL("/^([A-Za-z0-9]{5,})\/getway$/");
	}
}
?>