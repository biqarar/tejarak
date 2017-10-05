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
	public function enter()
	{
		$msg = null;
		if($this->displayname)
		{
			$msg = "✅ ". $this->displayname;
			if($this->plus)
			{
				$msg .= "\n➕ ". human::number($this->my_plus, $this->current_language);
			}
		}

		return $msg;
	}
}

?>