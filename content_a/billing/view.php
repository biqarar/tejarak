<?php
namespace content_a\billing;

class view
{
	public static function config()
	{

		\dash\data::amount(\dash\request::get('amount'));
		\dash\data::page_title(T_("Billing information"));
		\dash\data::page_desc(T_("Check your balance, charge your account, and bill your invoices!"));

		if(\dash\user::login())
		{
			$userUnit             = \dash\app\units::find_user_unit(\dash\user::id(), true);
			$userUnit_id          = \dash\app\units::get_id($userUnit);
			$userUnit_id          = (int) $userUnit_id;
			if($userUnit          == 'dollar')
			{
				$userUnit             = '$';
			}
			\dash\data::userUnit(T_($userUnit));

			$userCash_all = \dash\db\transactions::budget(\dash\user::id(), ['unit' => 'all']);
			\dash\data::userCash_all($userCash_all);
			if(is_array($userCash_all))
			{
				$userCash_all['total']    = array_sum($userCash_all);
			}
			\dash\data::userCash($userCash_all);

			\dash\data::usage(\content_a\billing\model::usage());


			\dash\data::history(self::get_billing());
		}
	}


	/**
	 * get billing data to show
	 */
	public static function get_billing()
	{
		if(!\dash\user::login())
		{
			return false;
		}

		$meta            = [];
		$meta['user_id'] = \dash\user::id();
		$meta['verify']  = 1;
		$billing_history = \dash\db\transactions::search(null, $meta);
		return $billing_history;
	}
}
?>