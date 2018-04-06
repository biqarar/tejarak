<?php
namespace lib\utility;

class message
{
	// the team id
	public $team_id          = null;
	// send by sms or telegram or other thing
	// send by every thing sms, telegram, ...
	public $send_by          = [];
	// the message must be send
	public $message          = [];
	// send notify to parent
	public $send_parent      = false;
	// the team details
	public $team_details     = [];
	// the team admins details
	public $team_admins      = [];
	public $admins_detail_id = [];
	// the team group chat id
	public $team_group       = null;
	// if the status is false no sending any thing
	public $status           = true;
	public $team_name        = null;
	public $team_short_name  = null;
	// the message type
	public $type             = [];
	// format of message
	// as json
	// or im
	public $format           = 'im';
	// the report header and footer
	public $report_header    = null;
	public $report_footer    = null;
	// every thing need to create the message
	// for example count hours
	// minus, plus, ....
	// set by function __call()
	public $meta             = [];
	// other function

	use message\ready;
	use message\check_plan;
	use message\send;
	use message\make\enter;
	use message\make\exit_message;
	use message\make\date_now;
	use message\make\end_day;
	use message\make\first_enter;
	use message\make\timed_auto_report;
	use message\make\thismonth;
	use message\make\today;
	use message\make\lasttraffic;
	use message\make\present;
	use message\make\absent;
	use message\make\members;
	use message\make\memberstatus;
	use message\make\last24hour;

	/**
	 * set the team_id
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public function __construct($_team_id, $_option = [])
	{
		$this->team_id = $_team_id;
		$this->current_language = \lib\language::current();
	}


	/**
	 * get variable from $this->meta
	 *
	 * @param      <type>  $_name  The name
	 */
	public function __get($_name)
	{
		if(array_key_exists($_name, $this->meta))
		{
			return $this->meta[$_name];
		}

		return null;
	}


	/**
	 * set every variable
	 *
	 * @param      <type>  $_name   The name
	 * @param      <type>  $_value  The value
	 */
	public function __set($_name, $_value)
	{
		$this->meta[$_name] = $_value;
	}



	/**
	 * Sends a message.
	 */
	public function send()
	{
		// ready data
		// load admins
		// load team data
		$this->ready();

		// generate text message
		$this->generate_message();

		// send message by check feacher in team plan
		$this->send_message();

		// return true or false
		return $this->status;
	}


	/**
	 * Sends a by.
	 * send by telegram
	 * send by sms
	 * send by facebook
	 *
	 * @param      string  $_by    { parameter_description }
	 */
	public function send_by($_by = 'telegram')
	{
		$this->send_by[] = $_by;
		$this->send_by = array_unique($this->send_by);
		return $this;
	}


	/**
	 * format of message
	 *
	 * @param      <type>  $_type  The type
	 */
	public function format($_foramt)
	{
		$this->format = $_foramt;
		return $this;
	}


	/**
	 * Sends to parent.
	 *
	 * @param      <type>  $_foramt  The foramt
	 *
	 * @return     self    ( description_of_the_return_value )
	 */
	public function send_parent($_send = false)
	{
		$this->send_parent = $_send;
		return $this;
	}


	/**
	 * set the message type
	 *
	 * @param      <type>  $_type  The type
	 */
	public function type($_type)
	{
		$this->type[] = $_type;
		return $this;
	}


	/**
	 * Gets the message text.
	 */
	public function get_message_text()
	{
		// ready data
		// load admins
		// load team data
		$this->ready();

		// generate text message
		$this->generate_message();

		// return the message list
		return $this->message;
	}


	/**
	 * generate message by message type
	 * if the function by message type is exist
	 * run this
	 * on that function
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private function generate_message()
	{
		if($this->status)
		{
			if($this->type && is_array($this->type))
			{
				foreach ($this->type as $key => $value)
				{
					if(method_exists($this, $value))
					{
						// for example
						// $this->first_enter();
						// $this->date_now();
						$msg = $this->{$value}();
						if($msg)
						{
							if(\dash\url::isLocal())
							{
								$msg .= "\n #Dev";
							}
							$this->message[$value] = $msg;
						}
					}

				}
			}
			else
			{
				$this->status = false;
			}
		}
	}

}
?>