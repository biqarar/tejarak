<?php
namespace content_a\setup;

class view extends \content_a\main\view
{
	/**
	 * config
	 */
	public function config()
	{
		parent::config();

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

		// get team name from param
		// saved in enter at the first page of tejarak
		if(isset($_SESSION['param']['team']) && is_string($_SESSION['param']['team']))
		{
			$this->data->param_team = $_SESSION['param']['team'];
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
		if(isset($_SESSION['last_team_added_code']))
		{
			$this->data->last_team_added_code = $_SESSION['last_team_added_code'];
		}
	}
}
?>