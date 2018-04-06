<?php
namespace content_a\member\edit;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function ready()
	{



		$new_url = \dash\url::here(). '/'. \dash\url::dir(0). '/member/general/'. \dash\url::dir(3);

		\dash\redirect::to($new_url);


		$this->get(false, 'edit')->ALL("/.*/");
		$this->post('edit')->ALL("/.*/");
	}
}
?>