<?php
namespace lib\utility\message\make;


trait members
{

	public function members()
	{
		$active   = \lib\db\teams::get_active_member($this->team_id);
		$active   = array_map(function($_a){ $_a['active_deactive'] = 'active'; return $_a;}, $active);
		$deactive = \lib\db\teams::get_deactive_member($this->team_id);
		$deactive = array_map(function($_a){ $_a['active_deactive'] = 'deactive'; return $_a;}, $deactive);

		foreach ($deactive as $key => $value)
		{
			array_push($active, $value);
		}

		$members = $active;

		$msg = null;

		if($members && is_array($members))
		{
			foreach ($members as $key => $value)
			{
				if(isset($value['displayname']))
				{
					if($value['active_deactive'] === 'active')
					{
						$msg .= "\n🔷 ".  $value['displayname'];
					}
					else
					{
						$msg .= "\n▫ ".  $value['displayname'];
					}
				}
			}
		}

		if($msg)
		{
			$msg = "#". T_("Member_status"). "\n". \dash\date::fit_lang('l j F Y H:i', time() , 'current') . "\n". $msg;
			$msg .= "\n👥 ". \dash\utility\human::number(count($members), \dash\language::current());
		}
		return $msg;
	}
}
?>