<?php
namespace lib\utility\message\make;


trait last24hour
{

	public function last24hour()
	{
		return $this->timed_auto_report();
	}

}
?>