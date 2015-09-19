<?php

class TblBoard extends AppModel
{
    public $name = 'TblBoard';
    public $useTable = 'tbl_boards';

	public function getList($page, $limit = 10) {

		return $this->find('all',array(
			'conditions'=>array(),
			'order'     => 'id DESC',
			'limit'     => $limit,
			'offset'    => ($page - 1) * $limit,
		));

	}//function


	public function add($comment, $admin_flag = false) {

		$data = array(
			'comment'    => $comment,
			'admin_flag' => ($admin_flag) ? 1: 0,
			'created_at' => date("Y-m-d H:i:s"),
		);

		$this->save($data);

	}//function

}

