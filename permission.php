<?php

// self::$perm_list[] =
// [
// 	'caller'      => 'add:team',
// 	'title'       => T_("Add new team"),
// 	'desc'        => T_("Add new team"),
// 	'group'       => 'plan_1',
// 	'need_check'  => true,
// 	'need_verify' => true,
// 	'enable'      => true,
// 	'parent'      => null, // 1,5
// ];

/*admin:view*/
self::$perm_list[201] =
[
	'caller' => 'admin:view',
	'title'  => T_("Can view the admin page"),
	'group'  => 'admin',
];

/*admin:add*/
self::$perm_list[202] =
[
	'caller' => 'admin:add',
	'title'  => T_("Can add hourse for all users in admin page"),
	'group'  => 'admin',
	'parent' => 'admin:view',
];

/*admin:edit*/
self::$perm_list[203] =
[
	'caller' => 'admin:edit',
];

/*admin:admin*/
self::$perm_list[204] =
[
	'caller' => 'admin:admin',
];

/*home:view*/
self::$perm_list[205] =
[
	'caller' => 'home:view',
];

/*home:admin*/
self::$perm_list[206] =
[
	'caller' => 'home:admin',
];

/*home:add*/
self::$perm_list[207] =
[
	'caller' => 'home:add',
];

/*remote:view*/
self::$perm_list[208] =
[
	'caller' => 'remote:view',
];

/*secret:view*/
self::$perm_list[209] =
[
	'caller' => 'secret:view',
];










//===================================
self::$perm_list[210] =
[
	'title'  => T_("Allow to show transaction list"),
	'caller' => 'cp:transaction',
];

self::$perm_list[211] =
[
	'title'  => T_("Allow to add new transaction list manualy"),
	'caller' => 'cp:transaction:add',
];

self::$perm_list[212] =
[
	'title'  => T_("Allow to show system logs"),
	'caller' => 'cp:transaction:logs',
];

self::$perm_list[213] =
[
	'title'  => T_("Allow to login by another session"),
	'caller' => 'enter:another:session',
];

?>