<?php
namespace content_cp\teams\members;

class controller extends \mvc\controller
{
	public $fields =
	[
		'id',
		'team_id',
		'user_id',
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
		'avatar',
		'postion',
		'displayname',
		'firstname',
		'lastname',
		'status',
		'desc',
		'meta',
		'createdate',
		'date_modified',
		'sort',
		'visibility',
		'reportdaily',
		'reportenterexit',
		'sort',
		'order',
		'search',
		'page'
	];

	public function ready()
	{
		\lib\permission::access('cp:user:members', 'block');

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