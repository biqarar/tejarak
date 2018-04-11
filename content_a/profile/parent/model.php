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
		$this->user_id = \dash\user::id();
		\dash\app::variable(['id' => \dash\coding::encode($this->user_id)]);
		$result = $this->get_list_parent();
		return $result;
	}


	/**
	 * cancel request
	 */
	public function cancel_request()
	{
		$this->user_id = \dash\user::id();
		\dash\app::variable(['id' => \dash\request::post('cancel')]);
		$this->parent_cancel_request();
		$this->redirector_refresh();
	}


	/**
	 * redirect to full
	 */
	public function redirector_refresh()
	{
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
			return;
		}
		return;
	}


	/**
	 * Removes a parent.
	 */
	public function remove_parent()
	{
		$this->user_id = \dash\user::id();
		\dash\app::variable(['id' => \dash\request::post('remove')]);
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

		$this->user_id = \dash\user::id();

		$request               = [];

		$request['othertitle'] = \dash\request::post('othertitle');
		$request['title']      = \dash\request::post('title');
		$request['mobile']     = \dash\request::post('mobile');
		$request['id']         = \dash\coding::encode($this->user_id);

		\dash\app::variable($request);

		if(\dash\request::post('cancel') && \dash\coding::is(\dash\request::post('cancel')))
		{
			$this->cancel_request();
			return ;
		}

		if(\dash\request::post('remove') && \dash\coding::is(\dash\request::post('remove')))
		{
			$this->remove_parent();
			return ;
		}

		$this->add_parent();
		$this->redirector_refresh();
	}
}
?>