<?php

class SpotUser extends AppModel
{
	public function get($spot_user_id) {
		return $this->find('first', array(
			'conditions'=>array('id'=>$spot_user_id)
		));
	}


	public function getList($page, $limit = 10, $sort = null) {

		if (is_null($sort)) {
			$order = "ORDER BY u.id DESC";
		} else if($sort == 'count') {
			$order = "ORDER BY count DESC";
		}
		$offset = ($page - 1) * $limit;
		$sql = "
 SELECT
  m.user_id as user_id,
  count(m.id) as count,
  u.title as title
 FROM spot_user_mylists m
 LEFT JOIN users u ON m.user_id = u.id
 WHERE m.delete_flag = :delete_flag
 GROUP BY m.user_id
 {$order}
 LIMIT {$offset}, {$limit};
";
		$params = array(
			'delete_flag'=> 0,
		);

		return $this->query($sql,$params);
	}

}

