<?php
namespace database\newtejarak;
class userteams
{
	public $id            = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $team_id    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'team'         ,'type'=>'int@10'                          ,'foreign'=>'teams@id!id'];
	public $user_id       = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $postion       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'postion'         ,'type'=>'varchar@255'];
	public $code          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'int@10'];
	public $telegram_id   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'telegram'        ,'type'=>'varchar@50'                      ,'foreign'=>'telegrams@id!id'];
	public $full_time     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'time'            ,'type'=>'bit@1'];
	public $remote        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'remote'          ,'type'=>'bit@1'];
	public $is_default    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'default'         ,'type'=>'bit@1'];
	public $date_enter    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'enter'           ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_exit     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'exit'            ,'type'=>'datetime@'];
	public $status        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire!enable'];
	public $createdate    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $desc          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'desc'            ,'type'=>'text@'];
	public $meta          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function team_id()
	{
		$this->form()->type('select')->name('team_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function postion()
	{
		$this->form()->type('textarea')->name('postion')->maxlength('255');
	}
	//--------------------------------------------------------------------------------id
	public function code()
	{
		$this->form()->type('number')->name('code')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------foreign
	public function telegram_id()
	{
		$this->form()->type('select')->name('telegram_')->maxlength('50');
		$this->setChild();
	}

	public function full_time(){}
	//--------------------------------------------------------------------------------id
	public function remote(){}

	public function is_default(){}

	public function date_enter()
	{
		$this->form()->type('text')->name('enter');
	}

	public function date_exit()
	{
		$this->form()->type('text')->name('exit');
	}
	//--------------------------------------------------------------------------------id
	public function status()
	{
		$this->form()->type('radio')->name('status');
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function createdate(){}

	public function date_modified(){}
	//--------------------------------------------------------------------------------id
	public function desc()
	{
		$this->form('#desc')->type('textarea')->name('desc');
	}
	//--------------------------------------------------------------------------------id
	public function meta(){}
}
?>