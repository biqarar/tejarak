<?php
namespace lib\utility;
use \lib\db;

class invoices
{
	public static $old_plan_name = null;
	public static $new_plan_name = null;
	public static $old_plan_code = null;
	public static $new_plan_code = null;
	public static $team_id       = null;
	public static $team_details  = [];

	use invoices\full;
	use invoices\make;
	/**
	 * check old team plans and
	 *
	 * @param      <type>  $_team_id  The team identifier
	 * @param      array   $_args     The arguments
	 */
	public static function team_plan($_team_id, $_args = [])
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}

		self::$team_id = $_team_id;

		self::$team_details = \lib\db\teams::get_by_id($_team_id);

		if(!isset($_args['new']['plan']))
		{
			return false;
		}

		self::$new_plan_code = $_args['new']['plan'];
		self::$new_plan_name = \lib\utility\plan::plan_name(self::$new_plan_code);
		if(!self::$new_plan_name)
		{
			return false;
		}

		if(isset($_args['current']['plan']))
		{
			self::$old_plan_code = $_args['current']['plan'];
			self::$old_plan_name = \lib\utility\plan::plan_name(self::$old_plan_code);
		}

		$is_ok = false;

		switch (self::$old_plan_name)
		{
			case 'free':
				// need less to make invoice
				// return true to change the plan
				$is_ok = true;
				break;

			case 'full':
				$is_ok = self::plan_full_break($_team_id, $_args);
				break;
			case 'simple':
			case 'standard':
				$is_ok = self::make_plan_invoice($_team_id, $_args);
				break;
			default:
				// for old plan can change to new plan
				$is_ok = true;
				break;
		}

		if($is_ok)
		{
			switch (self::$new_plan_name)
			{
				case 'free':
					$is_ok = true;
					break;

				case 'full':
					// save new transaction for full plan
					$is_ok = self::make_full_invoice($_team_id, $_args);
					break;

				case 'simple':
				case 'standard':
					// the invoice of this plan set when the user left this plan
					$is_ok = true;
					break;

				default:
					// new plan if not in this list
					// user can set it!
					$is_ok = true;
					break;
			}
		}
		return $is_ok;
	}


}
?>