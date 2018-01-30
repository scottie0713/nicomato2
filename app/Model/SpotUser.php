<?php

class SpotUser extends AppModel
{
	public function get($spot_user_id)
	{
		return $this->find('first', array(
			'conditions'=>array('id'=>$spot_user_id)
		));
	}


	public function getList($page, $limit = 10, $sort = null)
	{
		if (is_null($sort)) {
			$order = "ORDER BY id DESC";
		}
		$offset = ($page - 1) * $limit;
		$sql    = "SELECT id, title FROM spot_users {$order} LIMIT {$offset}, {$limit};";

		return $this->query($sql);
	}

}

