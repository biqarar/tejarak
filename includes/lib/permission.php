<?php
namespace lib;

/**
 * Class for permission.
 */
class permission
{
	/**
	 * return list of permission
	 */
	public static function list()
	{
		$list = [];

		/**
		 * plan 1
		 */
		$list[1] =
		[
			'caller'      => 'add:company',
			'title'       => T_("Add new company"),
			'desc'        => T_("Add new company"),
			'group'       => 'plan_1',
			'need_check'  => true,
			'need_verify' => false,
			'enable'      => true,
		];



		/**
		 * plan 2
		 */
		$list[2] =
		[
			'caller'      => 'add:branch',
			'title'       => T_("Add new branch"),
			'desc'        => T_("Add new branch"),
			'group'       => 'plan_2',
			'need_check'  => true,
			'need_verify' => false,
			'enable'      => true,
		];

		return $list;
	}
}
?>