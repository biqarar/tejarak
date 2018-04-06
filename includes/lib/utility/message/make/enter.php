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
					$T_T =
					[
						'name' => $this->displayname,
						'team' => $this->team_name,
						'time' => human::number(date("H:i"), $this->current_language),
					];
					$msg = T_(":name entered in :team at :time", $T_T);
					$msg .= "\n\n". 'tejarak.'.\dash\url::tld(). '/'. $this->team_short_name;

					break;

				default:
					$msg = "✅ ". $this->displayname;
					if($this->plus)
					{
						$msg .= "\n➕ ". human::number($this->plus, $this->current_language);
					}

					break;
			}
		}

		return $msg;
	}
}

?>