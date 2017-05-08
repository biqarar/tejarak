<?php
namespace database\newtejarak;
class hourlogs
{
	public $id             = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $company_id     = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'company'         ,'type'=>'int@10'                          ,'foreign'=>'companys@id!id'];
	public $user_id        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $usercompany_id = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'usercompany'     ,'type'=>'int@10'                          ,'foreign'=>'usercompanys@id!id'];
	public $userbranch_id  = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'userbranch'      ,'type'=>'int@10'                          ,'foreign'=>'userbranchs@id!id'];
	public $date           = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'date'            ,'type'=>'date@'];
	public $shamsi_date    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'date'            ,'type'=>'date@'];
	public $time           = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'time'            ,'type'=>'time@'];
	public $minus          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'minus'           ,'type'=>'int@10'];
	public $plus           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'plus'            ,'type'=>'int@10'];
	public $type           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'type'            ,'type'=>'enum@enter,exit'];
	public $createdate     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified  = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function company_id()
	{
		$this->form()->type('select')->name('company_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function usercompany_id()
	{
		$this->form()->type('select')->name('usercompany_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function userbranch_id()
	{
		$this->form()->type('select')->name('userbranch_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function date()
	{
		$this->form()->type('text')->name('date')->required();
	}

	public function shamsi_date()
	{
		$this->form()->type('text')->name('date')->required();
	}
	//--------------------------------------------------------------------------------id
	public function time()
	{
		$this->form()->type('text')->name('time')->required();
	}
	//--------------------------------------------------------------------------------id
	public function minus()
	{
		$this->form()->type('number')->name('minus')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function plus()
	{
		$this->form()->type('number')->name('plus')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function type()
	{
		$this->form()->type('radio')->name('type');
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function createdate(){}

	public function date_modified(){}
}
?>