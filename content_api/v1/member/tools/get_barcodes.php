<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get_barcodes
{
	public function get_barcodes(&$_data)
	{
		$multi = false;
		if(array_key_exists(0, $_data))
		{
			$multi = true;
		}

		$userteam_ids = [];

		if(!$multi)
		{
			if(isset($_data['id']))
			{
				$userteam_ids = [$_data['id']];
			}
		}
		else
		{
			$userteam_ids = array_column($_data, 'id');
		}

		$userteam_ids_decode = array_map(function($_a){return \lib\utility\shortURL::decode($_a);}, $userteam_ids);

		$get_multi_codes =
		[
			'ids'     => $userteam_ids_decode,
			'related' => 'userteams',
			'status'  => 'enable',
		];

		$get_multi_codes = \lib\db\my_codes::get_multi_codes($get_multi_codes);

		$codes = [];
		if(is_array($get_multi_codes))
		{
			foreach ($get_multi_codes as $key => $value)
			{
				if(isset($value['related_id']) && isset($value['termusage_type']) && isset($value['slug']))
				{
					$related_encode = \lib\utility\shortURL::encode($value['related_id']);
					$codes[$related_encode][$value['termusage_type']] = $value['slug'];
				}
			}
		}

		if(!empty($codes))
		{
			if($multi)
			{
				foreach ($_data as $key => $value)
				{
					if(isset($value['id']))
					{
						if(array_key_exists($value['id'], $codes))
						{
							$_data[$key]['codes'] = $codes[$value['id']];
						}
					}
				}
			}
			else
			{
				if(isset($_data['id']) && isset($codes[$_data['id']]))
				{
					$_data['codes'] = $codes[$_data['id']];
				}
			}
		}
	}
}
?>