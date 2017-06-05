<?php
namespace database\newtejarak;
class branchs
{
	public $id            = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $team_id    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'team'         ,'type'=>'int@10'                          ,'foreign'=>'teams@id!id'];
	public $title         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'title'           ,'type'=>'varchar@500'];
	public $brand         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'brand'           ,'type'=>'varchar@100'];
	public $site          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'site'            ,'type'=>'varchar@1000'];
	public $boss          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'boss'            ,'type'=>'int@10'];
	public $creator       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'creator'         ,'type'=>'int@10'];
	public $technical     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'technical'       ,'type'=>'int@10'];
	public $address       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'address'         ,'type'=>'text@'];
	public $code          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'int@10'];
	public $telegram_id   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'telegram'        ,'type'=>'varchar@50'                      ,'foreign'=>'telegrams@id!id'];
	public $phone_1       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'1'               ,'type'=>'varchar@50'];
	public $phone_2       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'2'               ,'type'=>'varchar@50'];
	public $phone_3       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'3'               ,'type'=>'varchar@50'];
	public $fax           = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'fax'             ,'type'=>'varchar@50'];
	public $email         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'email'           ,'type'=>'varchar@50'];
	public $post_code     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'code'            ,'type'=>'varchar@50'];
	public $full_time     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'time'            ,'type'=>'bit@1'];
	public $remote        = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'remote'          ,'type'=>'bit@1'];
	public $is_default    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'default'         ,'type'=>'bit@1'];
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
	//--------------------------------------------------------------------------------id
	public function title()
	{
		$this->form('#title')->type('textarea')->name('title')->maxlength('500')->required();
	}
	//--------------------------------------------------------------------------------id
	public function brand()
	{
		$this->form()->type('text')->name('brand')->maxlength('100');
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
		$this->form()->type('number')->name('creator')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function technical()
	{
		$this->form()->type('number')->name('technical')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function address()
	{
		$this->form()->type('textarea')->name('address');
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

	public function phone_1()
	{
		$this->form()->type('text')->name('1')->maxlength('50');
	}

	public function phone_2()
	{
		$this->form()->type('text')->name('2')->maxlength('50');
	}

	public function phone_3()
	{
		$this->form()->type('text')->name('3')->maxlength('50');
	}
	//--------------------------------------------------------------------------------id
	public function fax()
	{
		$this->form()->type('text')->name('fax')->maxlength('50');
	}
	//--------------------------------------------------------------------------------id
	public function email()
	{
		$this->form('#email')->type('email')->name('email')->maxlength('50');
	}

	public function post_code()
	{
		$this->form()->type('text')->name('code')->maxlength('50');
	}

	public function full_time(){}
	//--------------------------------------------------------------------------------id
	public function remote(){}

	public function is_default(){}
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