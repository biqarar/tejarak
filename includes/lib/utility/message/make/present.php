<?php
namespace lib\utility\message\make;


trait present
{

	public function present()
	{
		$result = \lib\db\teams::get_active_member($this->team_id);
		$msg = null;
		if($result && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if(isset($value['displayname']))
				{
					$msg .= "\n🔹 ".  $value['displayname'];
				}
			}
		}

		if($msg)
		{
			$msg = "#". T_("Presents"). "\n". \dash\date::fit_lang('l j F Y H:i', time() , 'current') . "\n". $msg;
			$msg .= "\n👥 ". \dash\utility\human::number(count($result), \lib\language::current());
		}
		return $msg;
	}
}
?>