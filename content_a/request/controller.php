<?php
namespace content_a\request;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{


		// request list
		$this->get(false, 'hour')->ALL("/.*/");
		$this->post('hour')->ALL("/.*/");


		// $this->get(false, 'showTime')->ALL("/^([a-zA-Z0-9]+)\/request(|\=([a-zA-Z0-9]+))$/");
		// $this->post('save')->ALL("/^([a-zA-Z0-9]+)\/request(|\=([a-zA-Z0-9]+))$/");
		// // show list of request time
		// $this->get(false, 'showRequestList')->ALL("/^([a-zA-Z0-9]+)\/request\/list$/");
		// $url = \lib\router::get_url();
		// if(preg_match("/^([a-zA-Z0-9]+)\/request\/list$/", $url))
		// {
		// 	$this->display_name = 'content_a\\request\\list.html';
		// }
		// $this->post('accept_reject')->ALL("/^([a-zA-Z0-9]+)\/request\/list$/");


		// // show detail of one request
		// $this->get(false, 'showRequestDetail')->ALL("/^([a-zA-Z0-9]+)\/request\/detail\=([a-zA-Z0-9]+)$/");
		// $url = \lib\router::get_url();
		// if(preg_match("/^([a-zA-Z0-9]+)\/request\/detail\=([a-zA-Z0-9]+)$/", $url))
		// {
		// 	$this->display_name = 'content_a\\request\\detail.html';
		// }

		// $this->delete('request')->ALL("/^([a-zA-Z0-9]+)\/request\/remove\=([a-zA-Z0-9]+)$/");
	}
}
?>