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

		// check url like this /ermile/sarshomar
		if(preg_match("/^([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)$/", $url, $split))
		{
			if(isset($split[1]) && isset($split[2]))
			{
				// check tema exist
				if($this->is_exist_team($split[1]))
				{
					// check branch of this team exists
					if(\lib\db\branchs::get_by_brand($split[1], $split[2]))
					{
						\lib\router::set_controller('content\\hours\\controller');
						return;
					}
				}
			}
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