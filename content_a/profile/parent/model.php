<?php
namespace content_a\profile\parent;


class model extends \content_a\main\model
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
		$this->user_id = \lib\user::id();
		\lib\utility::set_request_array(['id' => \lib\utility\shortURL::encode($this->user_id)]);
		$result = $this->get_list_parent();
		return $result;
	}


	/**
	 * cancel request
	 */
	public function cancel_request()
	{
		$this->user_id = \lib\user::id();
		\lib\utility::set_request_array(['id' => \lib\request::post('cancel')]);
		$this->parent_cancel_request();
		$this->redirector_refresh();
	}


	/**
	 * redirect to full
	 */
	public function redirector_refresh()
	{
		if(\lib\engine\process::status())
		{
			\lib\redirect::pwd();
			return;
		}
		return;
	}


	/**
	 * Removes a parent.
	 */
	public function remove_parent()
	{
		$this->user_id = \lib\user::id();
		\lib\utility::set_request_array(['id' => \lib\request::post('remove')]);
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

		$this->user_id = \lib\user::id();

		$request               = [];

		$request['othertitle'] = \lib\request::post('othertitle');
		$request['title']      = \lib\request::post('title');
		$request['mobile']     = \lib\request::post('mobile');
		$request['id']         = \lib\utility\shortURL::encode($this->user_id);

		\lib\utility::set_request_array($request);

		if(\lib\request::post('cancel') && \lib\utility\shortURL::is(\lib\request::post('cancel')))
		{
			$this->cancel_request();
			return ;
		}

		if(\lib\request::post('remove') && \lib\utility\shortURL::is(\lib\request::post('remove')))
		{
			$this->remove_parent();
			return ;
		}

		$this->add_parent();
		$this->redirector_refresh();
	}
}
?>