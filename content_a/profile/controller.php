<?php
namespace content_a\profile;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{

		$this->get(false, 'profile')->ALL('profile');
		$this->post('profile')->ALL('profile');
	}
}
?>