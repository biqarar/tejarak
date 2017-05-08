<?php
namespace database\newtejarak;
class getwaies
{
	public $id            = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $company_id    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'company'         ,'type'=>'int@10'                          ,'foreign'=>'companys@id!id'];
	public $branch_id     = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'branch'          ,'type'=>'int@10'                          ,'foreign'=>'branchs@id!id'];
	public $user_id       = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $title         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'title'           ,'type'=>'varchar@255'];
	public $cat           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'cat'             ,'type'=>'varchar@255'];
	public $code          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'int@10'];
	public $ip            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'ip'              ,'type'=>'int@10'];
	public $agent_id      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'agent'           ,'type'=>'int@10'                          ,'foreign'=>'agents@id!id'];
	public $status        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire!enable'];
	public $createdate    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $desc          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'desc'            ,'type'=>'text@'];
	public $meta          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function company_id()
	{
		$this->form()->type('select')->name('company_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function branch_id()
	{
		$this->form()->type('select')->name('branch_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function title()
	{
		$this->form('#title')->type('textarea')->name('title')->maxlength('255');
	}
	//--------------------------------------------------------------------------------id
	public function cat()
	{
		$this->form()->type('textarea')->name('cat')->maxlength('255');
	}
	//--------------------------------------------------------------------------------id
	public function code()
	{
		$this->form()->type('number')->name('code')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function ip()
	{
		$this->form()->type('number')->name('ip')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------foreign
	public function agent_id()
	{
		$this->form()->type('select')->name('agent_');
		$this->setChild();
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