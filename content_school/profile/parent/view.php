<?php
namespace content_school\profile\parent;

class view extends \content_school\main\view
{
	public function view_parent()
	{
		$list = $this->model()->list_parent();
		// var_dump($list);exit();
		$this->data->parent_list = $list;
	}
}
?>