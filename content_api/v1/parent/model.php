<?php
namespace content_api\v1\parent;
use \lib\debug;
use \lib\utility;
use \lib\db\logs;

class model extends \content_api\v1\home\model
{
	use tools\add;
	use tools\get;
	use tools\delete;


	public function get_one_parent()
	{
		return $this->get_parent();
	}

	/**
	 * Gets the parent list.
	 *
	 * @return     <type>  The parent list.
	 */
	public function get_parentList()
	{
		return $this->get_list_parent();
	}


	/**
	 * Posts a set telegram group.
	 */
	public function post_setTelegramGroup()
	{
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];


		if(!$this->user_id)
		{
			debug::error(T_("User id not found"));
			return false;
		}
		for kse in sselifs
		$code  = utility::request('id');
		$group = utility::request('group');

		if(!$code)
		{
			logs::set('api:parent:telegram:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("id not set"), 'id', 'arguments');
			return false;
		}

		if(!$group)
		{
			logs::set('api:parent:telegram:group:not:set', $this->user_id, $log_meta);
			debug::error(T_("group not set"), 'group', 'arguments');
			return false;
		}

		$load_parent = \lib\db\parents::access_parent_code($code,$this->user_id, ['action'=> 'edit']);

		if(!isset($load_parent['parent_id']))
		{
			debug::error(T_("Can not access to load this parent"), 'id', 'arguments');
			return false;
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
				'old'   => $load_parent,
			]
		];

		logs::set('api:parent:telegram:group:changed', $this->user_id, $log_meta);
		\lib\db\parents::update(['telegram_id' => $group], $load_parent['parent_id']);

		debug::title(T_("Operation complete"));
	}
}
?>