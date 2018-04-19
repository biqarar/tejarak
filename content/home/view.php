<?php
namespace content\home;

class view
{
	public static function config()
	{
		if(\dash\data::tejarak_home_page())
		{
			\dash\data::display_tejarak_home('content/home/home.html');
			\dash\data::bodyclass('unselectable vflex');
			\dash\data::page_title(\dash\data::site_title() . ' | '. \dash\data::site_slogan());
			\dash\data::page_special(true);
		}
		else
		{
			\dash\data::display_tejarak_home('content/home/board.html');
			\dash\data::bodyclass('unselectable attendance two-column');
			\dash\data::currentTime(date("Y-m-d H:i:s"));
			\dash\data::include_css(true);
			self::view_show();
		}
	}


	public static function listMember()
	{
		$request              = [];
		$request['shortname'] = \dash\url::directory();
		$request['hours']     = true;
		\dash\app::variable($request);
		$result =  \lib\app\member::get_list_member();
		return $result;
	}


	/**
	 * show hous page of team
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function view_show()
	{
		$team                 = \dash\url::module();
		$request              = [];
		$request['shortname'] = $team;
		if(\dash\temp::get('listMember'))
		{
			\dash\data::listMember(\dash\temp::get('listMember'));
		}
		else
		{
			\dash\data::listMember(self::listMember());
		}

		$current_team = \lib\app\team::getTeamDetailShortname($team);

		if(!isset($current_team['logo']) || (isset($current_team['logo']) && !$current_team['logo']))
		{
			$current_team['logo'] = \dash\url::site(). '/static/images/logo.png';
		}
		/**
		 * check team language and redirect if is set
		 * the 'data' mean the arguments of this function is data of team
		 * you can set the id or shortname of team and change the data to 'id' or 'shortname'
		 */
		\lib\app\team::checkout_team_lanuage_force($current_team, 'data');

		if(isset($current_team['logo']) && $current_team['logo'])
		{
			if(isset($current_team['id']))
			{
				$team_id = \dash\coding::decode($current_team['id']);
				if($team_id)
				{
					if(!\lib\utility\plan::access('show:logo', $team_id))
					{
						$current_team['logo'] = \dash\url::site(). '/static/images/logo.png';
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


		\dash\data::currentTeam($current_team);

		if(isset($current_team['name']))
		{
			\dash\data::page_title(T_($current_team['name']));
		}
		else
		{
			\dash\data::page_title(T_($team));
		}
		// set page desc
		\dash\data::page_desc(T_('Tejarak provides beautiful solutions for your business;'));
		if(isset($current_team['desc']))
		{
			\dash\data::page_desc($current_team['desc']. ' | '. \dash\data::page_desc());
		}
		// set page logo
		if(isset($current_team['logo']))
		{
			\dash\data::share_image($current_team['logo']);
		}
	}
}
?>