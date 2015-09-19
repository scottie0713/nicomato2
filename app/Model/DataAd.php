<?php

class DataAd extends AppModel
{
    public $name = 'DataAd';
    public $useTable = 'data_ads';

	public function get($platform, $code = null) {

		$dt = date("Y-m-d H:i:s");
		$res = $this->find('first',array(
			'conditions' => array(
				'code' => $code,
				'platform' => $platform,
				'delete_flag' => 0,
				'start_at <=' => $dt,
				'end_at >' => $dt,
			),
			'order' => 'RAND()',
		));

		return isset($res[$this->name]) ? $res[$this->name]['html'] : '';

	}//function

}

