<?php
namespace content_a\setup;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{


		$url = \lib\router::get_url();

		if($this->login())
		{
			if(isset($_SESSION['first_go_to_setup']) && $_SESSION['first_go_to_setup'] === true)
			{
				// no problem to continue
			}
			else
			{
				if(\lib\db\userteams::get(['user_id' => $this->login('id'), 'limit' => 1]))
				{
					\lib\error::bad(T_("You have a team and can not start the installation process again!"));
				}
				else
				{
					$_SESSION['first_go_to_setup'] = true;
				}
			}
		}

		// redirect setup to setup/1
		if($url === 'setup')
		{
			$this->redirector()->set_domain()->set_url('a/setup/1')->redirect();
			return;
		}

		// set the display name of every step 1,2,3
		switch ($url)
		{
			case 'setup/1':
				$this->display_name = 'content_a\setup\setup1.html';
				break;

			case 'setup/2':
				$this->display_name = 'content_a\setup\setup2.html';
				break;

			case 'setup/3':
				$this->display_name = 'content_a\setup\setup3.html';
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