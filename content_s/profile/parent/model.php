<?php
namespace content_s\profile\parent;
use \lib\debug;
use \lib\utility;

class model extends \content_s\main\model
{
	public $get_data;
	public $parent_id;

	/**
	 * get list parent
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function list_parent()
	{
		$this->user_id = $this->login('id');

		$result = $this->get_list_parent();
		return $result;
	}


	/**
	 * cancel request
	 */
	public function cancel_request()
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => utility::post('cancel')]);
		$this->parent_cancel_request();
		$this->redirector_refresh();
	}


	/**
	 * redirect to full
	 */
	public function redirector_refresh()
	{
		if(debug::$status)
		{
			$this->redirector($this->url('full'));
			return;
		}
		return;
	}


	/**
	 * Removes a parent.
	 */
	public function remove_parent()
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => utility::post('remove')]);
		$this->delete_parent();
		$this->redirector_refresh();
	}


	/**
	 * Posts a setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_parent($_args)
	{
		$request = [];

		$request['othertitle']  = utility::post('othertitle');
		$request['title']       = utility::post('title');
		$request['mobile']      = utility::post('mobile');

		utility::set_request_array($request);
		$this->user_id = $this->login('id');


		if(utility::post('cancel') && \lib\utility\shortURL::is(utility::post('cancel')))
		{
			$this->cancel_request();
			return ;
		}

		if(utility::post('remove') && \lib\utility\shortURL::is(utility::post('remove')))
		{
			$this->remove_parent();
			return ;
		}

		$this->add_parent();
		$this->redirector_refresh();
	}
}
?>