<?php
namespace content_cp\teams;

class controller extends \mvc\controller
{
	public $fields =
	[
		'id',
		'name',
		'shortname',
		'website',
		'alias',
		'telegram_id',
		'24h',
		'remote',
		'allowminus',
		'allowplus',
		'showavatar',
		'privacy',
		'status',
		'creator',
		'fileid',
		'fileurl',
		'logo',
		'logourl',
		'plan',
		'startplan',
		'startplanday',
		'parent',
		'createdate',
		'date_modified',
		'reportheader',
		'reportfooter',
		'timed_auto_report',
		'order',
		'sort',
		'search',
	];

	public function ready()
	{

		\lib\permission::access('cp:user', 'block');


		$property                     = [];
		foreach ($this->fields as $key => $value)
		{
			$property[$value] = ["/.*/", true , $value];
		}

		$this->get(false, "list")->ALL(['property' => $property]);

	}
}
?>