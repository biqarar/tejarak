<?php
namespace content_a\profile\parent;

class view extends \content_a\main\view
{
	public function view_parent()
	{
		$list = $this->model()->list_parent();
		// var_dump($list);exit();
		$this->data->parent_list = $list;
	}
}
?>