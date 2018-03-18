<?php
namespace content_a\setting\plan;


class model extends \content_a\main\model
{
/**
	 * get plan data to show
	 */
	public function plan()
	{
		if(!\lib\user::login())
		{
			return false;
		}

		$team = \lib\url::dir(0);
		$team = \lib\utility\shortURL::decode($team);

		if(!$team)
		{
			\lib\db\logs::set('plan:invalid:team', \lib\user::id());
			\lib\notif::error(T_("Invalid team!"), 'team');
			return false;
		}

		return \lib\db\teamplans::current($team);

	}

	/**
	 * post data and update or insert plan data
	 */
	public function post_plan()
	{
		if(!\lib\user::login())
		{
			return false;
		}

		$plan = \lib\request::post('plan');
		if(!$plan)
		{
			\lib\db\logs::set('plan:plan:not:set', \lib\user::id());
			\lib\notif::error(T_("Please select one of plan"), 'plan');
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
			\lib\db\logs::set('plan:invalid:plan', \lib\user::id());
			\lib\notif::error(T_("Invalid plan!"), 'plan');
			return false;
		}

		$team = \lib\url::dir(0);
		$team = \lib\utility\shortURL::decode($team);

		if(!$team)
		{
			\lib\db\logs::set('plan:invalid:team', \lib\user::id());
			\lib\notif::error(T_("Invalid team!"), 'team');
			return false;
		}

		$access = \lib\db\teams::access_team_id($team, \lib\user::id(), ['action' => 'admin']);

		if(!$access)
		{
			\lib\db\logs::set('plan:no:access:to:change:plan', \lib\user::id());
			\lib\notif::error(T_("No access to change plan"), 'team');
			return false;
		}

		$args =
		[
			'team_id' => $team,
			'plan'    => $plan,
			'creator' => \lib\user::id(),
		];
		$result = \lib\db\teamplans::set($args);

		if($result)
		{
			\lib\notif::ok(T_("Your team plan was changed"));
			if(\lib\engine\process::status())
			{
				\lib\redirect::pwd();
			}
		}
		else
		{
			// \lib\notif::error(T_("Can not save this plan of your team"));
			return false;
		}
	}
}
?>