<?php
namespace database\newtejarak;
class invoices
{
	public $id               = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $date             = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'date'            ,'type'=>'datetime@'];
	public $user_id_seller   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'user _seller'    ,'type'=>'int@10'                          ,'foreign'=>'users@id!user__selle_displayname'];
	public $user_id          = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'user'            ,'type'=>'int@10'                          ,'foreign'=>'users@id!user_displayname'];
	public $temp             = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'temp'            ,'type'=>'bit@1'];
	public $title            = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'title'           ,'type'=>'varchar@500'];
	public $total            = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'total'           ,'type'=>'bigint@20'];
	public $total_discount   = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'discount'        ,'type'=>'int@10'];
	public $status           = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire!enable'];
	public $date_pay         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'pay'             ,'type'=>'datetime@'];
	public $transaction_bank = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'bank'            ,'type'=>'varchar@255'];
	public $discount         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'discount'        ,'type'=>'int@10'];
	public $vat              = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'vat'             ,'type'=>'int@10'];
	public $vat_pay          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'pay'             ,'type'=>'int@10'];
	public $final_total      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'total'           ,'type'=>'bigint@20'];
	public $count_detail     = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'detail'          ,'type'=>'smallint@5'];
	public $createdate       = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $desc             = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'desc'            ,'type'=>'text@'];
	public $meta             = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------id
	public function date()
	{
		$this->form()->type('text')->name('date')->required();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id_seller()
	{
		$this->form()->type('select')->name('user__seller');
		$this->setChild();
	}
	//--------------------------------------------------------------------------------foreign
	public function user_id()
	{
		$this->form()->type('select')->name('user_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function temp(){}
	//--------------------------------------------------------------------------------id
	public function title()
	{
		$this->form('#title')->type('textarea')->name('title')->maxlength('500')->required();
	}
	//--------------------------------------------------------------------------------id
	public function total()
	{
		$this->form()->type('number')->name('total')->max('99999999999999999999');
	}

	public function total_discount()
	{
		$this->form()->type('number')->name('discount')->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function status()
	{
		$this->form()->type('radio')->name('status')->required();
		$this->setChild();
	}

	public function date_pay()
	{
		$this->form()->type('text')->name('pay');
	}

	public function transaction_bank()
	{
		$this->form()->type('textarea')->name('bank')->maxlength('255');
	}
	//--------------------------------------------------------------------------------id
	public function discount()
	{
		$this->form()->type('number')->name('discount')->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function vat()
	{
		$this->form()->type('number')->name('vat')->max('9999999999');
	}

	public function vat_pay()
	{
		$this->form()->type('number')->name('pay')->max('9999999999');
	}

	public function final_total()
	{
		$this->form()->type('number')->name('total')->max('99999999999999999999');
	}

	public function count_detail()
	{
		$this->form()->type('number')->name('detail')->min()->max('99999');
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