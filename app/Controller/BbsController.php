<?php
App::uses('AppController', 'Controller');

class BbsController extends AppController {

	public $uses = array('TblBoard');

    /**
     * トップ
	 * @param page ページ数
     */
    public function index($page = 1) {

		$boards = $this->TblBoard->getList($page, BBS_LIST_LIMIT);
		$count = $this->TblBoard->find('count');


		// ----------
        // セット
		// ----------
        $this->set(compact('boards'));
		// ページャ
        $this->set('page', $page);
        $this->set('page_max', ceil(($count) / BBS_LIST_LIMIT));

    }//function

    /**
     * 
	 * @param post title セッション
	 * @param post url マイリスト/ユーザURL
	 * @param post password マイリスト/ユーザURL
     */
    public function commit() {

		$comment = $this->request->data('comment');
		$this->TblBoard->add(htmlspecialchars($comment, ENT_QUOTES, 'UTF-8'));
		$this->redirect('/bbs/index');
	}//function

}
