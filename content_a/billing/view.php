<?php
namespace content_a\billing;

class view extends \content_a\main\view
{
	public function config()
	{

		$this->data->amount        = \dash\request::get('amount');
		$this->data->page['title'] = T_("Billing information");
		$this->data->page['desc']  = T_("Check your balance, charge your account, and bill your invoices!");

		if(\dash\user::login())
		{
			$userUnit             = \dash\app\units::find_userUnit(\dash\user::id(), true);
			$userUnit_id          = \dash\app\units::get_id($userUnit);
			$userUnit_id          = (int) $userUnit_id;
			if($userUnit          == 'dollar')
			{
				$userUnit             = '$';
			}
			$this->data->userUnit = T_($userUnit);

			$user_cash_all = \dash\db\transactions::budget(\dash\user::id(), ['unit' => 'all']);
			$this->data->user_cash_all = $user_cash_all;
			if(is_array($user_cash_all))
			{
				$user_cash_all['total']    = array_sum($user_cash_all);
			}
			$this->data->user_cash = $user_cash_all;

			$this->data->usage = $this->model()->usage();
		}
	}



	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_billing($_args)
	{
		if(!\dash\user::login())
		{
			return;
		}

		$history = $_args->api_callback;
		// var_dump($history);exit();
		$this->data->history = $history;

	}

}
?>