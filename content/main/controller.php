<?php
namespace content\main;


class controller extends \mvc\controller
{
	// function _route()
	// {
	// 	parent::_route();
	// }
	//

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