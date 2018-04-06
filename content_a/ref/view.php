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
		if(!\lib\user::login())
		{
			return null;
		}

		$meta =
		[
			'get_count' => true,
			'data'  => \lib\user::id(),
		];
		$result = [];

		$result['click'] = \dash\db\logs::search(null, array_merge($meta, ['caller' => 'user:ref:set']));
		$result['signup'] = \dash\db\logs::search(null, array_merge($meta, ['caller' => 'user:ref:signup']));
		$result['profile'] = \dash\db\logs::search(null, array_merge($meta, ['caller' => 'user:ref:complete:profile']));
		return $result;
	}
}
?>