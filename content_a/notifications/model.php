<?php
namespace content_a\notifications;


class model
{
	use \content_a\notifications\change_owner;
	use \content_a\notifications\set_parent;

	public static $user_id = null;
	/**
	 * get notifications data to show
	 */
	public static function get_notifications()
	{
		if(!\dash\user::login())
		{
			return false;
		}
		$meta            = [];
		self::$user_id   = \dash\user::id();
		$meta['user_id'] = self::$user_id;
		$meta['status']  = ["IN", "('enable')"];
		$meta['sort']    = 'id';
		$meta['order']   = 'desc';
		$notify          = null; // \dash\db\notifications::search(null, $meta);
		$cat_list        = \dash\option::config('notification', 'cat');

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
	public static function post()
	{
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("You must login to pay amount"));
			return false;
		}

		if(\dash\request::post('notify_type') === 'owner')
		{
			self::change_owner();
		}

		if(\dash\request::post('notify_type') === 'parent')
		{
			self::set_parent();
		}


		\dash\redirect::pwd();
	}



}
?>