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

		\lib\redirect::to($new_url);


		$this->get(false, 'edit')->ALL("/.*/");
		$this->post('edit')->ALL("/.*/");
	}
}
?>