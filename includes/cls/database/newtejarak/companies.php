<?php
namespace database\newtejarak;
class teams
{
	public $id              = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $title           = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'title'           ,'type'=>'varchar@500'];
	public $site            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'site'            ,'type'=>'varchar@1000'];
	public $boss            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'boss'            ,'type'=>'int@10'];
	public $creator         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'creator'         ,'type'=>'int@10'];
	public $technical       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'technical'       ,'type'=>'int@10'];
	public $brand           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'brand'           ,'type'=>'varchar@100'];
	public $register_code   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'int@10'];
	public $economical_code = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'int@10'];
	public $telegram_id     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'telegram'        ,'type'=>'varchar@50'                      ,'foreign'=>'telegrams@id!id'];
	public $file_id         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'file'            ,'type'=>'int@20'                          ,'foreign'=>'files@id!id'];
	public $logo            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'logo'            ,'type'=>'int@20'];
	public $alias           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'alias'           ,'type'=>'varchar@1000'];
	public $plan            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'plan'            ,'type'=>'varchar@50'];
	public $until           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'until'           ,'type'=>'datetime@'];
	public $status          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire,deleted!enable'];
	public $createdate      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $desc            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'desc'            ,'type'=>'text@'];
	public $meta            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------id
	public function title()
	{
		$this->form('#title')->type('textarea')->name('title')->maxlength('500')->required();
	}
	//--------------------------------------------------------------------------------id
	public function site()
	{
		$this->form()->type('textarea')->name('site')->maxlength('1000');
	}
	//--------------------------------------------------------------------------------id
	public function boss()
	{
		$this->form()->type('number')->name('boss')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function creator()
	{
		$this->form()->type('number')->name('creator')->min()->max('9999999999')->required();
	}
	//--------------------------------------------------------------------------------id
	public function technical()
	{
		$this->form()->type('number')->name('technical')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function brand()
	{
		$this->form()->type('text')->name('brand')->maxlength('100');
	}

	public function register_code()
	{
		$this->form()->type('number')->name('code')->min()->max('9999999999');
	}

	public function economical_code()
	{
		$this->form()->type('number')->name('code')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------foreign
	public function telegram_id()
	{
		$this->form()->type('select')->name('telegram_')->maxlength('50');
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function file_id()
	{
		$this->form()->type('select')->name('file_');
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function logo()
	{
		$this->form()->type('number')->name('logo')->min()->max('99999999999999999999');
	}
	//--------------------------------------------------------------------------------id
	public function alias()
	{
		$this->form()->type('textarea')->name('alias')->maxlength('1000');
	}
	//--------------------------------------------------------------------------------id
	public function plan()
	{
		$this->form()->type('text')->name('plan')->maxlength('50');
	}
	//--------------------------------------------------------------------------------id
	public function until()
	{
		$this->form()->type('text')->name('until');
	}
	//--------------------------------------------------------------------------------id
	public function status()
	{
		$this->form()->type('radio')->name('status')->required();
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