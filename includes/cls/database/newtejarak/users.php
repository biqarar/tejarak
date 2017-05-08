<?php
namespace database\newtejarak;
class users
{
	public $id               = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $user_mobile      = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'mobile'          ,'type'=>'varchar@15'];
	public $user_email       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'email'           ,'type'=>'varchar@100'];
	public $user_pass        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'pass'            ,'type'=>'varchar@64'];
	public $user_displayname = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'displayname'     ,'type'=>'varchar@100'];
	public $user_meta        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];
	public $user_status      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@active,awaiting,deactive,removed,filter!awaiting'];
	public $user_permission  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'permission'      ,'type'=>'smallint@5'];
	public $user_createdate  = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@'];
	public $date_modified    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $user_username    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'username'        ,'type'=>'varchar@100'];
	public $user_group       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'group'           ,'type'=>'varchar@100'];
	public $user_file_id     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'file_id'         ,'type'=>'int@20'];
	public $user_chat_id     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'chat_id'         ,'type'=>'int@20'];

	//--------------------------------------------------------------------------------id
	public function id(){}

	public function user_mobile()
	{
		$this->form('#mobile')->type('text')->name('mobile')->maxlength('15')->required();
	}

	public function user_email()
	{
		$this->form('#email')->type('email')->name('email')->maxlength('100');
	}

	public function user_pass()
	{
		$this->form('#pass')->type('password')->name('pass')->maxlength('64');
	}

	public function user_displayname()
	{
		$this->form()->type('text')->name('displayname')->maxlength('100');
	}

	public function user_meta(){}

	public function user_status()
	{
		$this->form()->type('radio')->name('status');
		$this->setChild();
	}

	public function user_permission()
	{
		$this->form()->type('number')->name('permission')->min()->max('99999');
	}

	public function user_createdate(){}

	public function date_modified(){}

	public function user_username()
	{
		$this->form()->type('text')->name('username')->maxlength('100');
	}

	public function user_group()
	{
		$this->form()->type('text')->name('group')->maxlength('100');
	}

	public function user_file_id()
	{
		$this->form()->type('number')->name('file_id')->min()->max('99999999999999999999');
	}

	public function user_chat_id()
	{
		$this->form()->type('number')->name('chat_id')->min()->max('99999999999999999999');
	}
}
?>