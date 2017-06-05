<?php
namespace content\home;

class controller extends \mvc\controller
{
	public function config()
	{

	}

	// for routing check
	function _route()
	{
		$url = \lib\router::get_url();

		if($this->is_exist_team($url))
		{
			$this->get()->ALL("$url");
		}
	}

	/**
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function is_exist_team($_name)
	{
		$_name = \lib\utility\safe::safe($_name);

		if(!$this->login())
		{
			return false;
		}
		$search_meta              = [];
		$search_meta['brand']     = $_name;
		$search_meta['boss']      = $this->login('id');
		$search_meta['get_count'] = true;
		$search_meta['status']    = ['<>', "'deleted'"];
		// search in teams
		$search_team = \lib\db\teams::search(null, $search_meta);

		if(intval($search_team) === 1)
		{
			return true;
		}
		return false;
	}
}
?>