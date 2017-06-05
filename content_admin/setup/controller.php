<?php
namespace content_admin\setup;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		// redirect setup to setup/1
		if($url === 'setup')
		{
			$this->redirector()->set_domain()->set_url('admin/setup/1')->redirect();
			return;
		}

		// set the display name of every step 1,2,3
		switch ($url)
		{
			case 'setup/1':
				$this->display_name = 'content_admin\setup\setup1.html';
				break;

			case 'setup/2':
				$this->display_name = 'content_admin\setup\setup2.html';
				break;

			case 'setup/3':
				$this->display_name = 'content_admin\setup\setup3.html';
				break;
		}

		// route step 1
		$this->get(false, 'setup1')->ALL("setup/1");
		$this->post('setup1')->ALL("setup/1");

		// route step 2
		$this->get(false, 'setup2')->ALL("setup/2");
		$this->post('setup2')->ALL("setup/2");

		// route step 3
		$this->get(false, 'setup3')->ALL("setup/3");
		$this->post('setup3')->ALL("setup/3");
	}
}
?>