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