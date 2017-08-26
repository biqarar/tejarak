<?php
namespace content_a\notifications;
use \lib\utility;
use \lib\debug;
use \lib\utility\payment;

class model extends \content_a\main\model
{
	use change_owner;
	use set_parent;

	public $user_id = null;
	/**
	 * get notifications data to show
	 */
	public function get_notifications($_args)
	{
		if(!$this->login())
		{
			return false;
		}
		$meta            = [];
		$this->user_id   = $this->login('id');
		$meta['user_id'] = $this->user_id;
		$meta['status']  = ["IN", "('enable')"];
		$meta['sort']    = 'id';
		$meta['order']   = 'desc';
		$notify          = \lib\db\notifications::search(null, $meta);
		$cat_list        = \lib\option::config('notification', 'cat');

		if(is_array($notify))
		{
			foreach ($notify as $key => $value)
			{
				if(isset($value['category']) && isset($cat_list[$value['category']]))
				{
					if(isset($cat_list[$value['category']]['title']))
					{
						$notify[$key]['cat_title'] =  $cat_list[$value['category']]['title'];
					}

					if(array_key_exists('answer', $value))
					{
						if($value['answer'] === null)
						{

							if(isset($cat_list[$value['category']]['btn']) && is_array($cat_list[$value['category']]['btn']))
							{
								$notify[$key]['btn'] = [];
								foreach ($cat_list[$value['category']]['btn'] as $k => $v)
								{
									$notify[$key]['btn'][$k] = T_($v);
								}
							}

							if($notify[$key]['cat_title'] === 'change_owner')
							{
								if(isset($notify[$key]['meta']['team_id']))
								{
									$notify[$key]['meta']['team_calc'] = (new \lib\utility\calc($notify[$key]['meta']['team_id']))->type('calc')->calc();
								}
							}
						}
					}
				}
			}
		}

		return $notify;
	}

	/**
	 * post data and update or insert notifications data
	 */
	public function post_notifications()
	{
		if(!$this->login())
		{
			debug::error(T_("You must login to pay amount"));
			return false;
		}

		$this->user_id = $this->login('id');

		if(utility::post('notify_type') === 'owner')
		{
			$this->change_owner();
		}

		if(utility::post('notify_type') === 'parent')
		{
			$this->set_parent();
		}


		$this->redirector($this->url('full'));
	}



}
?>