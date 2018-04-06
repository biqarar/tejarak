<?php
namespace content\hours;

class view extends \mvc\view
{
	use \content_a\main\_use;

	function config()
	{
		$this->data->bodyclass    = 'unselectable attendance two-column';
		$this->data->current_time = date("Y-m-d H:i:s");

		// add life to page to refresh automatically after end this time
		// $this->data->bodyel = 'data-life=20000';
		$this->include->css    = true;
	}


	/**
	 * show hous page of team
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_show($_args)
	{
		$team = \dash\url::directory();
		$request            = [];
		$this->data->team   = $request['shortname']         = $team;
		if(\dash\temp::get('list_member'))
		{
			$this->data->list_member = \dash\temp::get('list_member');

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
				$team_id = \dash\coding::decode($current_team['id']);
				if($team_id)
				{
					if(!\lib\utility\plan::access('show:logo', $team_id))
					{
						$current_team['logo'] = $this->url->static. 'images/logo.png';
					}
				}
			}
		}

		// check event title and set date
		if(isset($current_team['event_date_gregorian']))
		{
			// get 2date
			$datenow   = new \DateTime("now");
			$dateevent = new \DateTime($current_team['event_date_gregorian']);
			$interval  = $dateevent->diff($datenow);
			if($datenow < $dateevent)
			{
				$current_team['event_remain'] = $interval->days;
			}
			else
			{
				$current_team['event_remain'] = $interval->days * (-1);
			}

			// get deadline datetime
			$deadline  = strtotime($current_team['event_date_gregorian']);
			if(isset($current_team['event']['days']))
			{
				$startDate = intval($current_team['event']['days']);
				if($startDate === 0)
				{
					$startDate = 1;
				}
			}
			else
			{
				$startDate = 20;
			}

			// calc deadline ramain date
			$current_team['event_remain'] = floor(($deadline - time()) / (60 * 60 * 24));
			if($current_team['event_remain'] <= 0)
			{
				$current_team['event_remain'] = 0;
			}
			$current_team['event_percent'] = (int) round(($current_team['event_remain'] * 100) / $startDate, 0);

			// add warn class to show best color
			if($current_team['event_percent'] <= 1)
			{
				$current_team['event_class']  = 'black';
				$current_team['event_remain'] = '?';
			}
			elseif($current_team['event_percent'] <= 10)
			{
				$current_team['event_class'] = 'red';
			}
			elseif($current_team['event_percent'] <= 30)
			{
				$current_team['event_class'] = 'orange';
			}
			elseif($current_team['event_percent'] <= 50)
			{
				$current_team['event_class'] = 'yellow';
			}
			// var_dump($current_team);
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