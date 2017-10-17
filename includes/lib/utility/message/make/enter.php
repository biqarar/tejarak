<?php
namespace lib\utility\message\make;
use \lib\utility\human;

trait enter
{

	/**
	 * make enter message
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public function enter($_type = null)
	{
		$msg = null;
		if($this->displayname)
		{
			switch ($_type)
			{
				case 'sms':
					$msg = $this->displayname. "\n". T_("Entered");
					break;

				default:
					$msg = "✅ ". $this->displayname;
					if($this->plus)
					{
						$msg .= "\n➕ ". human::number($this->my_plus, $this->current_language);
					}
					break;
			}
		}

		return $msg;
	}
}

?>