<?php
namespace content_a\notifications;


trait set_parent
{


	public static function set_parent()
	{
		// 'answer' => string 'reject' (length=6)
		//  'type' => string 'parent' (length=5)
		//  'notify' => string 'q' (length=1)

		if(!in_array(\dash\request::post('answer'), ['accept', 'reject']))
		{
			\dash\notif::error(T_("Invalid answer!"));
			return false;
		}

		$notify = \dash\request::post('notify');
		$notify = \dash\coding::decode($notify);

		if(!$notify)
		{
			\dash\notif::error(T_("Invalid notify!"));
			return false;
		}

		$child = \dash\request::post('child');
		$child = \dash\coding::decode($child);

		if(!$child)
		{
			\dash\notif::error(T_("Invalid parent!"));
			return false;
		}

		$get =
		[
			'user_id'         => \dash\user::id(),
			'category'        => 9,
			'read'            => null,
			'id'              => $notify,
			'status'          => 'enable',
			'needanswer'      => 1,
			'answer'          => null,
			'related_foreign' => 'users',
			'related_id'      => $child,
			'limit'           => 1,
		];

		$log_meta =
		[
			'meta' =>
			[
				'get' => $get,
			],
		];

		$check = null; //\dash\db\notifications::get($get);

		if(isset($check['meta']) && is_string($check['meta']) && substr($check['meta'], 0, 1) === '{')
		{
			$check['meta'] = json_decode($check['meta'], true);
		}

		if(isset($check['id']))
		{
			$update_notify =
			[
				'read'     => 1,
				'readdate' => date("Y-m-d H:i:s"),
			];

			$action = \dash\request::post('answer');

			$notify_set =
			[
				'cat'     => 'change_parent_action',
				'to'      => $check['user_idsender'],
				'content' => T_("Your request to set parent was :action", ['action' => T_($action)]),
			];
			// \dash\db\notifications::set($notify_set);

			if(\dash\request::post('answer') === 'accept')
			{
				// ACCEPT
				// the accept in index 0 of array answer in options
				$update_notify['answer'] = 0;
				\dash\db\logs::set('notify:change:parent:accept', \dash\user::id(), $log_meta);
				$user_id   = $check['user_idsender'];
				$parent_id = $check['user_id'];
				$title = isset($check['meta']['title']) ? $check['meta']['title'] : null;
				$check_exist = ['user_id' => $user_id, 'parent' => $parent_id, 'status' => 'enable', 'limit' => 1];

				$check_exist = \dash\db\userparents::get($check_exist);
				if(isset($check_exist['id']))
				{
					$update_userparents =
					[
						'title'  => $title,
						'status' => 'enable',
						'creator' => \dash\user::id(),
					];
					\dash\db\userparents::update($update_userparents, $check_exist['id']);
				}
				else
				{
					$insert_parent =
					[
						'user_id' => $user_id,
						'parent'  => $parent_id,
						'status'  => 'enable',
						'title'   => $title,
						'status'  => 'enable',
						'creator' => \dash\user::id(),
					];
					\dash\db\userparents::insert($insert_parent);
				}

			}
			else
			{
				// REJECT
				// the accept in index 0 of array answer in options
				$update_notify['answer'] = 1;
				\dash\db\logs::set('notify:change:parent:reject', \dash\user::id(), $log_meta);
			}

			// \dash\db\notifications::update($update_notify, $check['id']);
		}
		else
		{
			\dash\notif::error(T_("Invalid notify detail"));
			return false;
		}
	}
}
?>