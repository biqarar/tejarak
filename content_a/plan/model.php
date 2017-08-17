<?php
namespace content_a\plan;
use \lib\utility;
use \lib\debug;

class model extends \content_a\main\model
{
	/**
	 * get plan data to show
	 */
	public function plan()
	{
		if(!$this->login())
		{
			return false;
		}

		$team = \lib\router::get_url(0);
		$team = \lib\utility\shortURL::decode($team);

		if(!$team)
		{
			\lib\db\logs::set('plan:invalid:team', $this->login('id'));
			debug::error(T_("Invalid team!"), 'team');
			return false;
		}

		return \lib\db\teamplans::current($team);

	}

	/**
	 * post data and update or insert plan data
	 */
	public function post_plan()
	{
		if(!$this->login())
		{
			return false;
		}

		$plan = utility::post('plan');
		if(!$plan)
		{
			\lib\db\logs::set('plan:plan:not:set', $this->login('id'));
			debug::error(T_("Please select one of plan"), 'plan');
			return false;
		}


		/**
		 * list of active plan
		 *
		 * @var        array
		 */
		$all_plan_list =
		[
			// 'free',
			// 'pro',
			// 'business'
			'free',
			'simple',
			'standard',
			'full'
		];

		if(!in_array($plan, $all_plan_list))
		{
			\lib\db\logs::set('plan:invalid:plan', $this->login('id'));
			debug::error(T_("Invalid plan!"), 'plan');
			return false;
		}

		$team = \lib\router::get_url(0);
		$team = \lib\utility\shortURL::decode($team);

		if(!$team)
		{
			\lib\db\logs::set('plan:invalid:team', $this->login('id'));
			debug::error(T_("Invalid team!"), 'team');
			return false;
		}

		$access = \lib\db\teams::access_team_id($team, $this->login('id'), ['action' => 'admin']);

		if(!$access)
		{
			\lib\db\logs::set('plan:no:access:to:change:plan', $this->login('id'));
			debug::error(T_("No access to change plan"), 'team');
			return false;
		}

		$args =
		[
			'team_id' => $team,
			'plan'    => $plan,
			'creator' => $this->login('id'),
		];
		$result = \lib\db\teamplans::set($args);

		if($result)
		{
			debug::true(T_("Your team plan was changed"));
			return true;
		}
		else
		{
			// debug::error(T_("Can not save this plan of your team"));
			return false;
		}
	}
}
?>