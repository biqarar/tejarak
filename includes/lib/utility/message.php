<?php
namespace lib\utility;

class message
{
	// the team id
	public $team_id       = null;
	// send by sms or telegram or other thing
	public $send_by       = 'telegram'; // as default
	// the message must be send
	public $message       = [];
	// the team details
	public $team_details  = [];
	// the team admins details
	public $team_admins   = [];
	// the team group chat id
	public $team_group    = null;
	// if the status is false no sending any thing
	public $status        = true;
	// the message type
	public $message_type  = null;
	// the report header and footer
	public $report_header = null;
	public $report_footer = null;
	// other function

	use message\ready;
	use message\generate;
	use message\send;
	use message\make\timed_auto_report;
	use message\make\thismonth;
	use message\make\today;
	use message\make\lasttrafic;
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
	}


	/**
	 * Sends a message.
	 */
	public function send()
	{
		$this->message = array_filter($this->message);

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
		$this->send_by = $_by;
		return $this;
	}


	/**
	 * set the message type
	 *
	 * @param      <type>  $_type  The type
	 */
	public function message_type($_type)
	{
		$this->message_type = $_type;
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

		if(count($this->message) === 1 && isset($this->message[0]))
		{
			return $this->message[0];
		}
		else
		{
			return $this->message;
		}

	}

}
?>