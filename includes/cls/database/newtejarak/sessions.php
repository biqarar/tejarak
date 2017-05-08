<?php
namespace database\newtejarak;
class sessions
{
	public $id            = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'bigint@20'];
	public $code          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'varchar@64'];
	public $user_id       = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $status        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@active,terminate,expire,disable,changed,logout!active'];
	public $agent_id      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'agent'           ,'type'=>'int@10'                          ,'foreign'=>'agents@id!id'];
	public $ip            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'ip'              ,'type'=>'int@10'];
	public $count         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'count'           ,'type'=>'int@10!1'];
	public $createdate    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $last_seen     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'seen'            ,'type'=>'datetime@'];
	public $date_modified = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------id
	public function code()
	{
		$this->form()->type('text')->name('code')->maxlength('64')->required();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function status()
	{
		$this->form()->type('radio')->name('status')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function agent_id()
	{
		$this->form()->type('select')->name('agent_');
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function ip()
	{
		$this->form()->type('number')->name('ip')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function count()
	{
		$this->form()->type('number')->name('count')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function createdate(){}

	public function last_seen()
	{
		$this->form()->type('text')->name('seen');
	}

	public function date_modified(){}
}
?>