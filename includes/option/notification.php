<?php

/**
 * send notification status
 */
self::$config['notification']['status'] = true;
self::$config['notification']['sort'] =
[
	'telegram',
	'email',
	'sms',
];

/**
 * the notification cats
 */
self::$config['notification']['cat'] = [];
// news
self::$config['notification']['cat'][1] =
[
	'title'   => 'news',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];
// invoice
self::$config['notification']['cat'][2] =
[
	'title'   => 'invoice',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];


/**
 * notification
 * by verify
 */
// parent
self::$config['notification']['cat'][3] =
[
	'title'   => 'change_parent',
	'send_by' =>
	[
		'telegram',
		'email',
	],
	'btn'     =>
	[
		'accept_parent' => 'Accept', // T_("Accept")
		'reject_parent' => 'Reject', // T_("Reject")
	],
];
//  owner
self::$config['notification']['cat'][4] =
[
	'title'   => 'change_owner',
	'send_by' =>
	[
		'telegram',
		'email',
	],
	'btn'     =>
	[
		'accept_owner' => 'Accept', // T_("Accept")
		'reject_owner' => 'Reject', // T_("Reject")
	],
];


self::$config['notification']['cat'][5] =
[
	'title'   => 'public',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];



self::$config['notification']['cat'][6] =
[
	'title'   => 'useref',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];

self::$config['notification']['cat'][7] =
[
	'title'   => 'ref',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];


self::$config['notification']['cat'][8] =
[
	'title'   => 'change_owner_action',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];


self::$config['notification']['cat'][9] =
[
	'title'   => 'set_parent',
	'send_by' =>
	[
		'telegram',
		'email',
	],
	'btn'     =>
	[
		'accept_parent' => 'Accept', // T_("Accept")
		'reject_parent' => 'Reject', // T_("Reject")
	],
];


self::$config['notification']['cat'][10] =
[
	'title'   => 'change_parent_action',
	'send_by' =>
	[
		'telegram',
		'email',
	],
];


self::$config['notification']['cat'][1000] =
[
	'title'   => 'supervisor',

];

?>