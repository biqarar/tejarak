<?php
namespace content_a\setting\plan;


class model
{
/**
	 * get plan data to show
	 */
	public static function plan()
	{
		if(!\dash\user::login())
		{
			return false;
		}

		$team = \dash\request::get('id');
		$team = \dash\coding::decode($team);

		if(!$team)
		{
			\dash\db\logs::set('plan:invalid:team', \dash\user::id());
			\dash\notif::error(T_("Invalid team!"), 'team');
			return false;
		}

		return \lib\db\teamplans::current($team);

	}

	/**
	 * post data and update or insert plan data
	 */
	public static function post()
	{
		if(!\dash\user::login())
		{
			return false;
		}

		$plan = \dash\request::post('plan');
		if(!$plan)
		{
			\dash\db\logs::set('plan:plan:not:set', \dash\user::id());
			\dash\notif::error(T_("Please select one of plan"), 'plan');
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
			\dash\db\logs::set('plan:invalid:plan', \dash\user::id());
			\dash\notif::error(T_("Invalid plan!"), 'plan');
			return false;
		}

		$team = \dash\request::get('id');
		$team = \dash\coding::decode($team);

		if(!$team)
		{
			\dash\db\logs::set('plan:invalid:team', \dash\user::id());
			\dash\notif::error(T_("Invalid team!"), 'team');
			return false;
		}

		$access = \lib\db\teams::access_team_id($team, \dash\user::id(), ['action' => 'admin']);

		if(!$access)
		{
			\dash\db\logs::set('plan:no:access:to:change:plan', \dash\user::id());
			\dash\notif::error(T_("No access to change plan"), 'team');
			return false;
		}

		$args =
		[
			'team_id' => $team,
			'plan'    => $plan,
			'creator' => \dash\user::id(),
		];
		$result = \lib\db\teamplans::set($args);

		if($result)
		{
			\dash\notif::ok(T_("Your team plan was changed"));
			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
		else
		{
			// \dash\notif::error(T_("Can not save this plan of your team"));
			return false;
		}
	}
}
?>