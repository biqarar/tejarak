<?php
namespace content_a\member\edit;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{



		$new_url = \lib\url::here(). '/'. \lib\url::dir(0). '/member/general/'. \lib\url::dir(3);

		$this->redirector($new_url)->redirect();


		$this->get(false, 'edit')->ALL("/.*/");
		$this->post('edit')->ALL("/.*/");
	}
}
?>