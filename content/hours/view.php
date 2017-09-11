<?php
namespace content\hours;

class view extends \mvc\view
{
	use \content_a\main\_use;

	function config()
	{
		$this->data->bodyclass    = 'unselectable siftal attendance';
		$this->data->current_time = date("Y-m-d H:i:s");
	}


	/**
	 * show hous page of team
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_show($_args)
	{
		$team = \lib\router::get_url();
		$request            = [];
		$this->data->team   = $request['shortname']         = $team;
		if(\lib\temp::get('list_member'))
		{
			$this->data->list_member = \lib\temp::get('list_member');

		}
		else
		{
			$this->data->list_member = $this->model()->list_member($request);
		}

		$current_team = $this->model()->getTeamDetailShortname($team);
		if(!isset($current_team['logo']) || (isset($current_team['logo']) && !$current_team['logo']))
		{
			$current_team['logo'] = $this->url->static. 'images/logo.png';
		}
		/**
		 * check team language and redirect if is set
		 * the 'data' mean the arguments of this function is data of team
		 * you can set the id or shortname of team and change the data to 'id' or 'shortname'
		 */
		$this->checkout_team_lanuage_force($current_team, 'data');

		if(isset($current_team['logo']) && $current_team['logo'])
		{
			if(isset($current_team['id']))
			{
				$team_id = \lib\utility\shortURL::decode($current_team['id']);
				if($team_id)
				{
					if(!\lib\utility\plan::access('show:logo', $team_id))
					{
						$current_team['logo'] = $this->url->static. 'images/logo.png';
					}
				}
			}
		}

		$this->data->current_team = $current_team;

		if(isset($current_team['name']))
		{
			$this->data->page['title'] = T_($current_team['name']);
		}
		else
		{
			$this->data->page['title'] = T_($team);
		}
		// set page desc
		$this->data->page['desc']  = T_('Tejarak provides beautiful solutions for your business;');
		if(isset($current_team['desc']))
		{
			$this->data->page['desc'] = $current_team['desc']. ' | '. $this->data->page['desc'];
		}
		// set page logo
		if(isset($current_team['logo']))
		{
			$this->data->share['image'] = $current_team['logo'];
		}

	}
}
?>