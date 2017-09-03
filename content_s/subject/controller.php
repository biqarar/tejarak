<?php
namespace content_s\subject;

class controller extends \content_s\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();


		// ADD NEW subject
		$this->get(false, 'subject_add')->ALL("/^([a-zA-z0-9]+)\/subject\/add$/");
		$this->post('subject_add')->ALL("/^([a-zA-z0-9]+)\/subject\/add$/");

		// LIST subject
		$this->get(false, 'subject')->ALL("/^([a-zA-z0-9]+)\/subject$/");
		$this->post('subject')->ALL("/^([a-zA-z0-9]+)\/subject$/");

		// EDIT subject
		$this->get(false, 'subject_edit')->ALL("/^([a-zA-z0-9]+)\/subject\=([a-zA-Z0-9]+)$/");
		$this->post('subject_edit')->ALL("/^([a-zA-z0-9]+)\/subject\=([a-zA-Z0-9]+)$/");

		if(preg_match("/^([a-zA-z0-9]+)\/subject$/", $url))
		{
			$this->display_name = 'content_s\subject\subjectList.html';
		}

	}
}
?>