<?php
namespace content_admin\branch;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		// the add page similar team/ermile/branch
		// this page add a branch of ermile
		$add_reg = "/^team\/([a-zA-Z0-9]+)\/branch$/";

		$this->get(false, 'add')->ALL($add_reg);
		$this->post('add')->ALL($add_reg);

		// url like this team/ermile/branch=sarshomar
		// route to edit sarshomar
		$this->get(false, 'edit')->ALL(
		[
			'url'      => "/^team\/([a-zA-Z0-9]+)(.*)$/",
			'property' =>
			[
				'branch' => ["/^[a-zA-Z0-9]+$/", true, 'branch'],
			],
		]);

		// to save change items of branch
		$edit_reg = "/^team\/([a-zA-Z0-9]+)\/branch\=([a-zA-Z0-9]+)$/";
		$this->post('edit')->ALL($edit_reg);

		$dash_reg = "/^[^team][a-zA-Z0-9]+$/";
		if(preg_match($dash_reg, $url, $split))
		{

			$this->display_name = 'content_admin\branch\dashboard.html';
			if(isset($split[0]))
			{
				$this->get(false, 'dashboard')->ALL($split[0]);
			}
		}

	}
}
?>