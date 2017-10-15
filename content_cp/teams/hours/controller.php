<?php
namespace content_cp\teams\hours;

class controller extends \mvc\controller
{
	public $fields =
	[
		'id',
		'team_id',
		'user_id',
		'userteam_id',
		'date',
		'shamsi_date',
		'time',
		'minus',
		'plus',
		'type',
		'diff',
		'createdate',
		'date_modified',
		'rule',
		'personnelcode',
		'telegram_id',
		'allowplus',
		'allowminus',
		'24h',
		'remote',
		'isdefault',
		'dateenter',
		'dateexit',
		'fileid',
		'fileurl',
		'postion',
		'displayname',
		'firstname',
		'lastname',
		'status',
		'desc',
		'meta',
		'sort',
		'visibility',
		'reportdaily',
		'reportenterexit',
		'hour_id',
		'sort',
		'order',
		'search',
		'page'
	];

	public function ready()
	{
		\lib\permission::access('cp:user:hours', 'block');

		$property                     = [];
		foreach ($this->fields as $key => $value)
		{
			$property[$value] = ["/.*/", true , $value];
		}

		// $this->get(false, "list")->ALL(['url' => "/.*/", 'property' => $property]);
		// $this->get(false, "list")->ALL(['url' => "/.*/", 'property' => $property]);
		$this->get(false, "list")->ALL("/.*/");

	}
}
?>