<?php
namespace mvc;

class controller extends \lib\mvc\controller
{

	/**
	 * { function_description }
	 */
	public function _route()
	{
		// check if have cookie set login by remember
		if(!$this->login())
		{
			\content_enter\main\tools\login::login_by_remember();
		}

		/**
		 * if the user user 'en' language of site
		 * and her country is "IR"
		 * and no referer to this page
		 * and no cookie set from this site
		 * redirect to 'fa' page
		 * WARNING:
		 * this function work when the default lanuage of site is 'en'
		 * if the default language if 'fa'
		 * and the user work by 'en' site
		 * this function redirect to tj.com/fa/en
		 * and then redirect to tj.com/en
		 * so no change to user interface ;)
		 */
		if(\lib\define::get_language() != 'fa')
		{
			if(isset($_SERVER['HTTP_CF_IPCOUNTRY']) && mb_strtoupper($_SERVER['HTTP_CF_IPCOUNTRY']) === 'IR')
			{
				$refrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
				$cookie = \lib\utility::cookie();
				if(!$refrer && !$cookie)
				{
					$root    = $this->url('root');
					$full    = $this->url('full');
					$new_url = str_replace($root, $root. '/fa', $full);
					$this->redirector($new_url)->redirect();
				}
			}
		}
	}
}
?>