<?php
namespace content_admin\home;
use \lib\debug;
use \lib\utility;

class model extends \content_admin\main\model
{
	/**
	 * load brand comapny
	 *
	 * @param      <type>   $_url   The url
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function find_team($_url)
	{
		$_url = utility\safe::safe($_url);

		if(!$this->login())
		{
			return false;
		}

		$search_team = \lib\db\teams::search(null, ['brand' => $_url, 'boss' => $this->login('id'), 'get_count' => true]);
		if(intval($search_team) === 1)
		{
			return true;
		}
		return false;
	}
}
?>