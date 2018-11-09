<?php
namespace lib\utility;

class telegram
{

	/**
	 * sort telegram message and send
	 *
	 * @var        array
	 */
	public static $SORT = [];



	/**
	 * Sends a message via telegram
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function sendMessage($_chat_id, $_text, $_option = [])
	{
		if(!$_chat_id || !$_text)
		{
			return false;
		}

		$default_option =
		[
			'sort' => null,
		];

		if(is_array($_option))
		{
			$_option = array_merge($default_option, $_option);
		}

		$args =
		[
			'chat_id'    => $_chat_id,
			'text'       => $_text,
		];

		if($_option['sort'])
		{
			self::$SORT[] = ['sort' => $_option['sort'], 'curl' => $args];
		}
		else
		{
			// \dash\social\telegram\tg::sendMessage(['chat_id' => $_chat_id, 'text' => $_text]);
			return;
		}
	}



	/**
	 * Sends a message via telegram
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function sendMessageGroup($_chat_id, $_text, $_option = [])
	{

		if(!$_chat_id || !$_text)
		{
			return false;
		}

		$default_option =
		[
			'sort' => null,
		];

		if(is_array($_option))
		{
			$_option = array_merge($default_option, $_option);
		}

		$args =
		[
			'chat_id'    => $_chat_id,
			'text'       => $_text,
		];

		if($_option['sort'])
		{
			self::$SORT[] = ['sort' => $_option['sort'], 'curl' => $args];
		}
		else
		{
			// \dash\social\telegram\tg::sendMessage(['chat_id' => $_chat_id, 'text' => $_text]);
		}
	}


	/**
	* send message as sort
	*/
	public static function sort_send()
	{
		if(!empty(self::$SORT))
		{
			$sort = array_column(self::$SORT, 'sort');
			array_multisort($sort,SORT_ASC, self::$SORT);
			self::$SORT = array_filter(self::$SORT);
			$args = array_column(self::$SORT, 'curl');

			foreach ($args as $key => $value)
			{
				if(isset($value['chat_id']) && isset($value['text']))
				{
					\dash\social\telegram\tg::sendMessage(['chat_id' => $value['chat_id'], 'text' => $value['text']]);
				}
			}
		}
	}

	/**
	* clear cashed meessage
	*/
	public static function clean_cash()
	{
		self::$SORT = [];
	}
}
?>