<?php
namespace database\tejarak;
class users
{
	public $id               = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $mobile      = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'mobile'          ,'type'=>'varchar@15'];
	public $email       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'email'           ,'type'=>'varchar@50'];
	public $pass        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'pass'            ,'type'=>'varchar@64'];
	public $displayname = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'displayname'     ,'type'=>'varchar@50'];
	public $meta        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];
	public $status      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@active,awaiting,deactive,removed,filter!awaiting'];
	public $permission  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'permission'      ,'type'=>'smallint@5'];
	public $datecreated  = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@'];
	public $datemodified    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}

	public function mobile()
	{
		$this->form('#mobile')->type('text')->name('mobile')->maxlength('15')->required();
	}

	public function email()
	{
		$this->form('#email')->type('email')->name('email')->maxlength('50');
	}

	public function pass()
	{
		$this->form('#pass')->type('password')->name('pass')->maxlength('64');
	}

	public function displayname()
	{
		$this->form()->type('text')->name('displayname')->maxlength('50');
	}

	public function meta(){}

	public function status()
	{
		$this->form()->type('radio')->name('status');
		$this->setChild();
	}

	public function permission()
	{
		$this->form()->type('number')->name('permission')->min()->max('99999');
	}

	public function datecreated(){}

	public function datemodified(){}
}
?>