<?php
namespace lib\utility\plan;

trait feature_list
{
	public static function feature_list()
	{
		$plan = [];
		/**
		 * plan free
		 */
		$plan[1] =
		[
			'name'    => 'free',
			'detail'  => null,
			'amount'  => 0,
			'contain' =>
			[
				// no thing
			],
		];

		/**
		 * plan pro
		 */
		$plan[2] =
		[
			'name'    => 'pro',
			'detail'  => null,
			'amount'  => 0,
			'contain' =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		/**
		 * plan business
		 */
		$plan[3] =
		[
			'name'    => 'business',
			'detail'  => null,
			'amount'  => 0,
			'contain' =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];


		/**
		 * plan simple
		 */
		$plan[4] =
		[
			'name'    => 'simple',
			'detail'  => null,
			'amount'  => 2000,
			'contain' =>
			[
				'telegram:enter:msg'        => true,
				'telegram:exit:msg'         => true,
				'telegram:first:of:day:msg' => true,
				'telegram:end:day:report'   => true,
			],
		];


		/**
		 * plan standard
		 */
		$plan[5] =
		[
			'name'    => 'standard',
			'detail'  => null,
			'amount'  => 10000,
			'contain' =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		/**
		 * plan full
		 */
		$plan[6] =
		[
			'name'    => 'full',
			'detail'  => null,
			'amount'  => 499000,
			'contain' =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		/**
		 * plan full
		 */
		$plan[7] =
		[
			'name'    => 'full_free',
			'detail'  => null,
			'amount'  => 0,
			'contain' =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

			/**
		 * plan simple
		 */
		$plan[8] =
		[
			'name'    => 'simple_free',
			'detail'  => null,
			'amount'  => 0,
			'contain' =>
			[
				'telegram:enter:msg'        => true,
				'telegram:exit:msg'         => true,
				'telegram:first:of:day:msg' => true,
				'telegram:end:day:report'   => true,
			],
		];


		/**
		 * plan standard
		 */
		$plan[9] =
		[
			'name'    => 'standard_free',
			'detail'  => null,
			'amount'  => 0,
			'contain' =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		return $plan;
	}
}
?>