<?php
namespace database\newtejarak;
class invoice_details
{
	public $id            = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'id'              ,'type'=>'int@10'];
	public $invoice_id    = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'invoice'         ,'type'=>'int@10'                          ,'foreign'=>'invoices@id!id'];
	public $title         = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'title'           ,'type'=>'varchar@500'];
	public $price         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'price'           ,'type'=>'int@10'];
	public $count         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'count'           ,'type'=>'smallint@5'];
	public $total         = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'total'           ,'type'=>'int@10'];
	public $discount      = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'discount'        ,'type'=>'smallint@5'];
	public $status        = ['null'=>'NO'  ,'show'=>'YES'     ,'label'=>'status'          ,'type'=>'enum@enable,disable,expire!enable'];
	public $createdate    = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'createdate'      ,'type'=>'datetime@!CURRENT_TIMESTAMP'];
	public $date_modified = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'modified'        ,'type'=>'timestamp@'];
	public $desc          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'desc'            ,'type'=>'text@'];
	public $meta          = ['null'=>'YES' ,'show'=>'YES'     ,'label'=>'meta'            ,'type'=>'mediumtext@'];

	//--------------------------------------------------------------------------------id
	public function id(){}
	//--------------------------------------------------------------------------------foreign
	public function invoice_id()
	{
		$this->form()->type('select')->name('invoice_')->required();
		$this->setChild();
	}
	//--------------------------------------------------------------------------------id
	public function title()
	{
		$this->form('#title')->type('textarea')->name('title')->maxlength('500')->required();
	}
	//--------------------------------------------------------------------------------id
	public function price()
	{
		$this->form()->type('number')->name('price')->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function count()
	{
		$this->form()->type('number')->name('count')->max('99999');
	}
	//--------------------------------------------------------------------------------id
	public function total()
	{
		$this->form()->type('number')->name('total')->max('9999999999');
	}
	//--------------------------------------------------------------------------------id
	public function discount()
	{
		$this->form()->type('number')->name('discount')->max('99999');
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