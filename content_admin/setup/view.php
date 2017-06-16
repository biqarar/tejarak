<?php
namespace content_admin\setup;

class view extends \content_admin\main\view
{
	/**
	 * config
	 */
	public function config()
	{
		parent::config();

		// if  the user is login and first login
		// we set the setup field of user on 1
		if($this->login() && !$this->login('setup'))
		{
			$_SESSION['user']['setup'] = '1';
			\lib\db\users::update(['user_setup' => 1], $this->login('id'));
		}


		// set page title
		$step = null;
		switch (\lib\router::get_url(1))
		{
			case '1':
				$step                     = T_('Team');
				$this->data->page['desc'] = T_('Set team name');
				break;

			case '2':
				$step = T_('You');
				$this->data->page['desc'] = T_('Set your personal information');
				break;

			case '3':
				$step = T_('Finish');
				$this->data->page['desc'] = T_('Setup is finished!');
				break;
		}
		$this->data->page['title']   = T_('Tejarak Quick Setup');
		if($step)
		{
			$this->data->page['title'] .= ' | ' . $step;
		}
		$this->data->page['special'] = true;
		// $this->data->page['desc']    = $this->data->page['title'];

	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_setup1($_args)
	{

	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_setup2($_args)
	{

	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_setup3($_args)
	{
		if(isset($_SESSION['last_team_added']))
		{
			$this->data->last_team_added = $_SESSION['last_team_added'];
		}
	}
}
?>