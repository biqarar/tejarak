<?php
namespace content_cp\teamplans;

class controller extends \mvc\controller
{
	public $fields =
	[
		'id',
		'team_id',
		'plan',
		'start',
		'end',
		'creator',
		'desc',
		'meta',
		'createdate',
		'date_modified',
		'status',
		'lastcalcdate',
		'name',
		'shortname',
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