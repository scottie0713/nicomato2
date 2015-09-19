<?php
App::uses('AppController', 'Controller');

/**
 * =============================================
 *
 * DebugController
 * 開発/デバッグ用コントローラー
 *
 * =============================================
 */
class DebugController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $uses = array('DataMylist', 'UserMylist', 'UserRanking','User');
	public $components = array('Str');

    /**
     * マイページ
	 * @param user_id ユーザＩＤ
	 * @param page    ページ番号
     */
    public function mypage($user_id=1, $page = 1) {

		Configure::write('debug', 2);
		/*
		$ad = ($this->request->is('mobile'))
			? $this->DataAd->get(2)
			: $this->DataAd->get(1);
		*/
		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		if (count($this->User->get($user_id)) == 0) {
			$this->redirect('/');
		}

		$data_mylist_ids = $this->UserMylist->get($user_id);
        // 更新チェック
		$this->DataMylist->check($data_mylist_ids);
		//リスト取得
		$count = $this->UserMylist->getCount($user_id, null, 0);
		$mylists = $this->DataMylist->getList($data_mylist_ids, array(), $page, USER_MYPAGE_LIST_LIMIT);
		$users = $this->User->get($user_id);

        // 値をセット
        $this->set(compact('mylists','user_id','users'));
		$this->set('page', $page);
		$this->set('page_max', ceil($count / USER_MYPAGE_LIST_LIMIT));
    }

    /**
     * マイページ内検索結果
	 * @param user_id ユーザＩＤ
	 * @param page    ページ番号
     */
    public function search($user_id) {

		Configure::write('debug', 2);

		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		if (count($this->User->get($user_id)) == 0) {
			$this->redirect('/');
		}
		$search_str = $this->request->data('search');

		$data_mylist_ids = $this->UserMylist->get($user_id);
		$mylists = $this->DataMylist->searchList($data_mylist_ids, $search_str);
		$users = $this->User->get($user_id);

        // 値をセット
        $this->set('search', true);
        $this->set(compact('mylists'));
        $this->set(compact('user_id','users'));

		$this->render('/User/mypage');
    }


	public function detail($data_type, $mylist_str)
    {
		Configure::write('debug', 2);
		$res = array(
			'success' => false,
			'result' => array(),
		);
		//$data_type  = $this->request->data('data_type');
		//$mylist_str = $this->request->data('mylist_str');
		$mylist = $this->DataMylist->getByRss($data_type, $mylist_str, 50);
		$res['result'] = json_decode($mylist['before_movie_data']);
		$res['success']= true;

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }


}
