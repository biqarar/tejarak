<?php
namespace database\newtejarak;
class hours
{
	public $id                  = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $user_id             = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $company_id          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'company'         ,'type'=>'int@10'                          ,'foreign'=>'companys@id!id'];
	public $usercompany_id      = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'usercompany'     ,'type'=>'int@10'                          ,'foreign'=>'usercompanys@id!id'];
	public $userbranch_id       = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'userbranch'      ,'type'=>'int@10'                          ,'foreign'=>'userbranchs@id!id'];
	public $start_getway_id     = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'getway_id'       ,'type'=>'int@10'];
	public $end_getway_id       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'getway_id'       ,'type'=>'int@10'];
	public $start_userbranch_id = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'userbranch_id'   ,'type'=>'int@10'];
	public $end_userbranch_id   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'userbranch_id'   ,'type'=>'int@10'];
	public $date                = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'date'            ,'type'=>'date@'];
	public $year                = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'year'            ,'type'=>'int@4'];
	public $month               = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'month'           ,'type'=>'int@2'];
	public $day                 = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'day'             ,'type'=>'int@2'];
	public $shamsi_date         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'date'            ,'type'=>'date@'];
	public $shamsi_year         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'year'            ,'type'=>'int@4'];
	public $shamsi_month        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'month'           ,'type'=>'int@2'];
	public $shamsi_day          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'day'             ,'type'=>'int@2'];
	public $start               = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'start'           ,'type'=>'time@'];
	public $end                 = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'end'             ,'type'=>'time@'];
	public $diff                = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'diff'            ,'type'=>'int@10'];
	public $minus               = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'minus'           ,'type'=>'int@10'];
	public $plus                = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'plus'            ,'type'=>'int@10'];
	public $type                = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'type'            ,'type'=>'enum@nothing,base,wplus,wminus,all!all'];
	public $accepted            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'accepted'        ,'type'=>'int@10'];
	public $createdate          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $status              = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@active,awaiting,deactive,removed,filter!awaiting'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function company_id()
	{
		$this->form()->type('select')->name('company_')->required();
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

	public function start_getway_id()
	{
		$this->form()->type('number')->name('getway_id')->min()->max('9999999999')->required();
	}

	public function end_getway_id()
	{
		$this->form()->type('number')->name('getway_id')->min()->max('9999999999');
	}

	public function start_userbranch_id()
	{
		$this->form()->type('number')->name('userbranch_id')->min()->max('9999999999')->required();
	}

	public function end_userbranch_id()
	{
		$this->form()->type('number')->name('userbranch_id')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function date()
	{
		$this->form()->type('text')->name('date')->required();
	}
	//--------------------------------------------------------------------------------id
	public function year()
	{
		$this->form()->type('number')->name('year')->min()->max('9999')->required();
	}
	//--------------------------------------------------------------------------------id
	public function month()
	{
		$this->form()->type('number')->name('month')->min()->max('99')->required();
	}
	//--------------------------------------------------------------------------------id
	public function day()
	{
		$this->form()->type('number')->name('day')->min()->max('99')->required();
	}

	public function shamsi_date()
	{
		$this->form()->type('text')->name('date')->required();
	}

	public function shamsi_year()
	{
		$this->form()->type('number')->name('year')->min()->max('9999')->required();
	}

	public function shamsi_month()
	{
		$this->form()->type('number')->name('month')->min()->max('99')->required();
	}

	public function shamsi_day()
	{
		$this->form()->type('number')->name('day')->min()->max('99')->required();
	}
	//--------------------------------------------------------------------------------id
	public function start()
	{
		$this->form()->type('text')->name('start')->required();
	}
	//--------------------------------------------------------------------------------id
	public function end()
	{
		$this->form()->type('text')->name('end');
	}
	//--------------------------------------------------------------------------------id
	public function diff()
	{
		$this->form()->type('number')->name('diff')->min()->max('9999999999');
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
	public function accepted()
	{
		$this->form()->type('number')->name('accepted')->min()->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function createdate(){}

	public function date_modified(){}
	//--------------------------------------------------------------------------------id
	public function status()
	{
		$this->form()->type('radio')->name('status');
		$this->setChild();
	}
}
?>