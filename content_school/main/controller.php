<?php
namespace content_school\main;

class controller extends \mvc\controller
{

	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		if(!$this->login())
		{
			$this->redirector($this->view()->url->base)->redirect();
			return;
		}
	}


	/**
	 * check reserved names
	 * @return [type] [description]
	 */
	function reservedNames($_name)
	{
		$result = null;
		switch ($_name)
		{
			case 'home':
			case 'team':
			case 'billing':
			case 'school':
				$result = true;
				break;

			default:
				$result = false;
				break;
		}
		return $result;
	}

}
?>