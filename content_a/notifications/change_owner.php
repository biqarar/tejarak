<?php
namespace content_a\notifications;
use \lib\utility;
use \lib\debug;
use \lib\utility\payment;

trait change_owner
{


	public function change_owner()
	{
		// 'answer' => string 'reject' (length=6)
		//  'type' => string 'owner' (length=5)
		//  'notify' => string 'q' (length=1)

		if(!in_array(utility::post('answer'), ['accept', 'reject']))
		{
			debug::error(T_("Invalid answer!"));
			return false;
		}

		$notify = utility::post('notify');
		$notify = utility\shortURL::decode($notify);

		if(!$notify)
		{
			debug::error(T_("Invalid notify!"));
			return false;
		}

		$team_id = utility::post('team_code');
		$team_id = utility\shortURL::decode($team_id);

		if(!$team_id)
		{
			debug::error(T_("Invalid team id!"));
			return false;
		}

		$get =
		[
			'user_id'         => $this->login('id'),
			'category'        => 4,
			'read'            => null,
			'id'              => $notify,
			'status'          => 'enable',
			'needanswer'      => 1,
			'answer'          => null,
			'related_foreign' => 'teams',
			'related_id'      => $team_id,
			'limit'           => 1,
		];

		$log_meta =
		[
			'meta' =>
			[
				'get' => $get,
			],
		];

		$check = \lib\db\notifications::get($get);
		if(isset($check['id']))
		{
			$update_notify =
			[
				'read'     => 1,
				'readdate' => date("Y-m-d H:i:s"),
			];

			$action = utility::post('answer');

			$team_name = isset($check['meta']['team_name']) ? $check['meta']['team_name'] : null;

			$notify_set =
			[
				'cat'     => 'change_owner_action',
				'to'      => $check['user_idsender'],
				'content' => T_("Your request to change owner of team :team was :action", ['action' => T_($action), 'team' => $team_name]),
			];
			\lib\db\notifications::set($notify_set);

			if(utility::post('answer') === 'accept')
			{
				// ACCEPT
				// the accept in index 0 of array answer in options
				$update_notify['answer'] = 0;
				\lib\db\logs::set('notify:change:owner:accept', $this->login('id'), $log_meta);
				\lib\db\teams::update(['creator' => $this->login('id')], $team_id);
				$check_exist_team_user =
				[
					'team_id' => $team_id,
					'user_id' => $this->login('id'),
					'limit'   => 1,
				];
				$check_exist_team_user = \lib\db\userteams::get($check_exist_team_user);
				if(isset($check_exist_team_user['id']))
				{
					$update_user_team =
					[
						'rule'        => 'admin',
						'status'      => 'active',
						'displayname' => $this->login('displayname'),
					];
					\lib\db\userteams::update($update_user_team, $check_exist_team_user['id']);
				}
				else
				{
					$insert_user_team =
					[
						'team_id'     => $team_id,
						'user_id'     => $this->login('id'),
						'rule'        => 'admin',
						'status'      => 'active',
						'displayname' => $this->login('displayname'),
					];
					\lib\db\userteams::insert($insert_user_team);
				}

			}
			else
			{
				// REJECT
				// the accept in index 0 of array answer in options
				$update_notify['answer'] = 1;
				\lib\db\logs::set('notify:change:owner:reject', $this->login('id'), $log_meta);
			}

			\lib\db\notifications::update($update_notify, $check['id']);
		}
		else
		{
			debug::error(T_("Invalid notify detail"));
			return false;
		}

	}
}
?>