<?php
namespace content_a\ref;

class view extends \content_a\main\view
{
	public function view_ref($_args)
	{
		$result = $this->get_ref();
		if(is_array($result))
		{
			foreach ($result as $key => $value)
			{
				$this->data->$key = $value;
			}
		}
	}

	public function get_ref()
	{
		if(!$this->login())
		{
			return null;
		}

		$meta =
		[
			'get_count' => true,
			'data'  => $this->login('id'),
		];
		$result = [];

		$result['click'] = \lib\db\logs::search(null, array_merge($meta, ['caller' => 'user:ref:set']));
		$result['signup'] = \lib\db\logs::search(null, array_merge($meta, ['caller' => 'user:ref:signup']));
		$result['profile'] = \lib\db\logs::search(null, array_merge($meta, ['caller' => 'user:ref:complete:profile']));
		return $result;
	}
}
?>