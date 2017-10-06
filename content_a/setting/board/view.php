<?php
namespace content_a\setting\board;

class view extends \content_a\setting\view
{
		/**
	 * load team data to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_board($_args)
	{
		$this->data->page['desc'] = T_('Manage some options of board and force language and some other options.');
	}
}
?>