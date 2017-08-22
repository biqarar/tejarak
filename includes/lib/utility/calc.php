<?php
namespace lib\utility;
use \lib\db;

class calc
{

	use calc\full;
	use calc\make;

	// change or calc
	public $type                 = 'calc';

	// total calc amount
	public $total_calc_amount    = 0;
	// save transaction and invoice or just calc
	public $save                 = true;

	// send notify to creator when the calc is complete
	public $notify               = false;

	// team detail
	private $team_details        = [];
	private $team_id             = 0;
	private $old_teamplan_id     = null;
	// old plan detail
	private $old_plan_code       = null;
	private $old_plan_name       = null;
	private $old_plan_detail     = null;
	private $old_plan_amount     = null;
	private $old_plan_prepayment = null;
	// new plan details
	private $new_plan_code       = null;
	private $new_plan_name       = null;
	private $new_plan_detail     = null;
	private $new_plan_amount     = null;
	private $new_plan_prepayment = null;

	private $creator             = null;
	private $current_plan        = null;
	private $lastcalcdate        = null;

	private $creator_name        = null;
	private $creator_mobile      = null;

	private $log_meta            = [];
	private $user_id             = null;
	private $count_active_user   = null;
	private $active_time         = null;


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public function __construct($_team_id)
	{
		// \lib\db::transaction();

		$this->team_id = $_team_id;

		if(!$this->team_id || !is_numeric($this->team_id))
		{
			return false;
		}

		$this->team_details = \lib\db\teams::get_by_id($this->team_id);

		if(isset($this->team_details['creator']))
		{
			$this->creator = $this->team_details['creator'];
		}

		$this->current_plan = \lib\db\teamplans::current($this->team_id);

		if(isset($this->current_plan['lastcalcdate']))
		{
			$this->lastcalcdate = $this->current_plan['lastcalcdate'];
		}


		if(isset($this->current_plan['id']))
		{
			$this->old_teamplan_id = $this->current_plan['id'];
		}

		if($this->creator)
		{
			$user_data            = \lib\db\users::get($this->creator);
			$this->creator_name   = isset($user_data['user_displayname']) ? $user_data['user_displayname'] : null;
			$this->creator_mobile = isset($user_data['user_mobile']) ? $user_data['user_mobile'] : null;
		}

		$this->log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'team_id'      => $this->team_id,
				'team_details' => $this->team_details,
				'session'      => $_SESSION,
			],
		];

		if(isset($_SESSION['user']['id']))
		{
			$this->user_id = $_SESSION['user']['id'];
		}
		elseif($this->creator)
		{
			// $this->user_id = $this->creator;
		}
	}


	/**
	 * set the type
	 *
	 * @param      <type>  $_type  The type
	 */
	public function type($_type = 'calc')
	{
		// change plan
		// calc
		// calc_invoice
		$this->type = $_type;
		return $this;
	}


	/**
	 * Gets the active member.
	 *
	 * @return     <type>  The active member.
	 */
	public function get_active_member()
	{
		return $this->count_active_user;
	}


	/**
	 * Gets the active time.
	 *
	 * @return     <type>  The active time.
	 */
	public function get_active_time()
	{
		return $this->active_time;
	}


	/**
	 * load old plan details
	 *
	 * @param      <type>  $_old_plan_name  The old plan code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function old_plan($_old_plan_name)
	{
		$this->old_plan_name       = $_old_plan_name;
		$this->old_plan_code       = \lib\utility\plan::plan_code($this->old_plan_name);
		$this->old_plan_detail     = \lib\utility\plan::get_detail($this->old_plan_code);
		$this->old_plan_amount     = isset($this->old_plan_detail['amount']) ? floatval($this->old_plan_detail['amount']) : 0;
		$this->old_plan_prepayment = isset($this->old_plan_detail['prepayment']) ? $this->old_plan_detail['prepayment'] : null;
		return $this;
	}


	/**
	 * load new plan details
	 *
	 * @param      <type>  $_new_plan_name  The new plan code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function new_plan($_new_plan_name)
	{
		$this->new_plan_name       = $_new_plan_name;
		$this->new_plan_code       = \lib\utility\plan::plan_code($this->new_plan_name);
		$this->new_plan_detail     = \lib\utility\plan::get_detail($this->new_plan_code);
		$this->new_plan_amount     = isset($this->new_plan_detail['amount']) ? floatval($this->new_plan_detail['amount']) : 0;
		$this->new_plan_prepayment = isset($this->new_plan_detail['prepayment']) ? $this->new_plan_detail['prepayment'] : null;
		return $this;
	}


	/**
	 * save transaction and invocie
	 *
	 * @param      boolean  $_save  The save
	 */
	public function save($_save = true)
	{
		$this->save = $_save;
		return $this;
	}


	/**
	 * send notify
	 *
	 * @param      boolean  $_notify  The notify
	 */
	public function notify($_notify = true)
	{
		$this->notify = $_notify;
		return $this;
	}


	/**
	 * save old teamplan id to updat calc date
	 *
	 * @param      <type>  $_old_teamplan_id  The old teamplan identifier
	 */
	public function old_teamplan_id($_old_teamplan_id)
	{
		$this->old_teamplan_id = $_old_teamplan_id;
		return $this;
	}


	/**
	 * calc team plans
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function calc()
	{
		if(!$this->team_id || !is_numeric($this->team_id))
		{
			return false;
		}

		if($this->type === 'change_plan')
		{
			return $this->change_plan();
		}
		elseif($this->type === 'calc')
		{
			$current_plan = isset($this->current_plan['plan']) ? $this->current_plan['plan'] : null;
			if($current_plan)
			{
				$this->old_plan(\lib\utility\plan::plan_name($current_plan));
				$this->save   = false;

				switch ($this->old_plan_name)
				{
					case 'free':
						// need less to make invoice
						// return true to change the plan
						$amount = 0;
						break;

					case 'full':
						$amount = $this->plan_full_break();
						break;

					case 'simple':
					case 'standard':
						$amount = $this->make_plan_invoice();
						break;
					default:
						// for old plan can change to new plan
						$amount = 0;
						break;
				}
				return $amount;

			}
			else
			{
				return false;
			}
		}
		elseif($this->type === 'calc_invoice')
		{
			$current_plan = isset($this->current_plan['plan']) ? $this->current_plan['plan'] : null;
			if($current_plan)
			{
				$this->old_plan(\lib\utility\plan::plan_name($current_plan));
				$this->save   = true;

				switch ($this->old_plan_name)
				{
					case 'free':
						// need less to make invoice
						// return true to change the plan
						$is_ok = true;
						break;

					case 'full':
						$is_ok = $this->make_full_invoice();
						if(!$is_ok)
						{
							$new_plan =
							[
								'team_id'       => $this->team_id,
								'plan'          => \lib\utility\plan::plan_code('free'),
								// turn off auto make invoice
								'maked_invoice' => false,
							];
							$is_ok = \lib\db\teamplans::set($new_plan);
						}
						break;

					case 'simple':
					case 'standard':
						$is_ok = $this->make_plan_invoice();
						break;
					default:
						// for old plan can change to new plan
						$is_ok = true;
						break;
				}

				if($this->old_teamplan_id)
				{
					\lib\db\teamplans::update(['lastcalcdate' => date("Y-m-d H:i:s")], $this->old_teamplan_id);
				}
				return $is_ok;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}

	}


	/**
	 * change plan by check old plan and new plan
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	private function change_plan()
	{

		$is_ok                   = false;
		$make_full_invoice       = false;
		$make_full_invoice_check = false;

		switch ($this->old_plan_name)
		{
			case 'free':
				// need less to make invoice
				// return true to change the plan
				$is_ok = true;
				break;

			case 'full':
				$is_ok = $this->plan_full_break();
				break;

			case 'simple':
			case 'standard':
				if($this->new_plan_name === 'full')
				{
					$make_full_invoice = $this->make_full_invoice();

					$make_full_invoice_check = true;

					if($make_full_invoice)
					{
						$is_ok = $this->make_plan_invoice();
					}
				}
				else
				{
					$is_ok = $this->make_plan_invoice();
				}
				break;
			default:
				// for old plan can change to new plan
				$is_ok = true;
				break;
		}

		if($is_ok)
		{
			switch ($this->new_plan_name)
			{
				case 'free':
					$is_ok = true;
					break;

				case 'full':
					if(!$make_full_invoice_check)
					{
						// save new transaction for full plan
						$is_ok = $this->make_full_invoice();
					}
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

		if($this->save)
		{
			if($this->old_teamplan_id)
			{
				\lib\db\teamplans::update(['lastcalcdate' => date("Y-m-d H:i:s")], $this->old_teamplan_id);
			}
			return $is_ok;
		}
		else
		{
			return $this->total_calc_amount;
		}
	}
}
?>