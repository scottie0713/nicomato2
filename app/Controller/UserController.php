<?php
App::uses('AppController', 'Controller');

/**
 * =============================================
 *
 * UserController
 * ユーザ毎のページ表示
 *
 * =============================================
 */
class UserController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $uses = array('DataMylist', 'UserMylist', 'UserRanking','User');
	public $components = array('Str', 'Cookie');


    /**
     * マイページ
	 * @param user_id ユーザＩＤ
	 * @param page    ページ番号
     */
    public function mypage($user_id, $page = 1, $limit = USER_MYPAGE_LIST_LIMIT) {

		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		if (count($this->User->get($user_id)) == 0) {
			$this->redirect('/');
		}

		// user_mylist取得
		$user_mylists = $this->UserMylist->getByUserId($user_id);
		$data_mylist_ids = array();
		$check_data_mylist_ids = array();
		foreach($user_mylists as $user_mylist){
			$data_mylist_ids[] = $user_mylist['UserMylist']['data_mylist_id'];
			if ($user_mylist['UserMylist']['check_flag'] == 1) {
				$check_data_mylist_ids[] = $user_mylist['UserMylist']['data_mylist_id'];
			}
		}

        // 更新チェック
        if ( count($check_data_mylist_ids) > 0) {
			$this->DataMylist->check($check_data_mylist_ids);
        }

		//リスト取得
		$count = $this->UserMylist->getCount($user_id, null, 0);
		$mylists = $this->DataMylist->getList($data_mylist_ids, array(), $page, $limit);
		$users = $this->User->get($user_id);

        // 値をセット
        $this->set(compact('mylists','user_id','users'));
		$this->set('page', $page);
		$this->set('page_max', ceil($count / USER_MYPAGE_LIST_LIMIT));
    }

	/**
	 * マイページ設定ページ
	 * マイリストの追加/編集、パスワード変更など
	 * @param user_id ユーザＩＤ
	 */
    public function setting($user_id)
    {
		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		// user
		$user = $this->User->get($user_id);
		if (count($user) == 0) {
			$this->redirect('/');
		}

		//リスト取得
		$mylists = $this->UserMylist->getWithData($user_id);

		//パスワード
		$password = '';
		if ($this->Cookie->read('session')) {
			$cookie_session = $this->Cookie->read('session');
			if ($cookie_session == $user['User']['session']) {
				$password = $user['User']['password'];
			}
		}
		$this->set('title', $user['User']['title']);
		$this->set('password', $password);
        $this->set('mylists', $mylists);
        $this->set('user_id', $user_id);
    }

    /**
     * マイページ内検索結果
	 * @param user_id ユーザＩＤ
     */
    public function search($user_id) {

		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		if (count($this->User->get($user_id)) == 0) {
			$this->redirect('/');
		}
		$search_str = $this->request->data('search');

		$user_mylists = $this->UserMylist->getByUserId($user_id);
		$data_mylist_ids = array();
		foreach($user_mylists as $user_mylist){
			$data_mylist_ids[] = $user_mylist['UserMylist']['data_mylist_id'];
		}
		$mylists = $this->DataMylist->searchList($data_mylist_ids, $search_str);
		$users = $this->User->get($user_id);

        // 値をセット
        $this->set('search', true);
        $this->set(compact('mylists'));
        $this->set(compact('user_id','users'));

		$this->render('/User/mypage');
    }


    /**
     * [API] 過去動画取得ＡＰＩ
	 * @param data_type
	 * @param mylist_str
     */
	public function detail($data_type, $mylist_str)
    {
		$res = array(
			'success' => false,
			'result' => array(),
		);
		$mylist = $this->DataMylist->getByRss($data_type, $mylist_str, 50);
		$res['result'] = json_decode($mylist['before_movie_data']);
		$res['success']= true;

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }


    /**
     * [API] パスワード認証
	 * パスワードをチェックし、セッションを発行する
	 * @param user_id ユーザID
	 * @param password パスワード
     */
    public function auth($user_id,$password)
    {
        $res = array(
            'success'    => false,
            'session' => "",
        );
        $users = $this->User->get($user_id);
		if ($password == $users['User']['password']) {
			$res['success'] = true;
			$res['session'] = md5(date("YmdHis"));
			$users['User']['session'] = $res['session'];
			$users['User']['updated_at'] = date("Y-m-d H:i:s");
			$this->User->save($users);
			// cookie期限は1ヶ月
			$this->Cookie->write("session", $res['session'], false, (3600*24*7));
		}
        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }


    /**
     * [API] フラグ更新
	 * @param int user_id ユーザID
	 * @param post sesstion セッション
	 * @param post text マイリストＩＤリスト
     */
    public function changeMylistFlag($user_id)
    {
		$res = array(
			'success' => true,
			'code'  => 'ok',
			'msg' => ''
		);

		$session = $this->request->data('session');
		if( $this->checkSession($user_id, $session) ){
			$mode = $this->request->data('mode');
			$data_type = $this->request->data('data_type');
			$mylist_str= $this->request->data('mylist_str');

			$data_mylist = $this->DataMylist->getOneByMylistStr($data_type, $mylist_str);
			if($mode == 'delete_on' ) {
				$this->UserMylist->updateDeleteFlag($user_id, $data_mylist['DataMylist']['id'], 1);
			} else if($mode == 'delete_off') {
				$this->UserMylist->updateDeleteFlag($user_id, $data_mylist['DataMylist']['id'], 0);
			} else if($mode == 'check_on' ) {
				$this->UserMylist->updateCheckFlag($user_id, $data_mylist['DataMylist']['id'], 1);
			} else if($mode == 'check_off') {
				$this->UserMylist->updateCheckFlag($user_id, $data_mylist['DataMylist']['id'], 0);
			} else {
				$res['msg'] = '無効なパラメータです';
				$res['code']= 'param_err';
				$res['success'] = false;
			}

		} else {
			$res['msg'] = '認証に失敗しました';
			$res['code']= 'auth_err';
			$res['success'] = false;
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }


    /**
     * [API] マイリスト追加
	 * @param int user_id ユーザID
	 * @param post sesstion セッション
	 * @param post text マイリストＩＤリスト
     */
    public function addMylist($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);

		$session = $this->request->data('session');
		if( $this->checkSession($user_id, $session) ){

			$str = $this->request->data('text');
			if (is_null($str) || $str == ''){
				$res['msg'] = '何も入力されていません';
			} else {
				$mylists = explode("\n", $str);

				foreach($mylists as $mylist) {
					$mylist_str = $this->Str->getMylistStr($mylist);
					$data_type = $this->Str->getDataType($mylist);
					if ($mylist_str != false){
						$data_mylist_id = $this->DataMylist->add($data_type, $mylist_str);
						if (!$data_mylist_id){
							$res['msg'] = '登録に失敗したものがあります';
							continue;
						}
						$user_mylist = array(
							'user_id' => $user_id,
							'data_mylist_id' => $data_mylist_id,
							'check_flag' => 0,
							'delete_flag'=> 0,
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s"),
						);
						$this->UserMylist->create();
						$this->UserMylist->save($user_mylist);
						$res['success'] = true;
					}//if

				}//foreach
			}//if

		} else {
			$res['msg'] = '認証に失敗しました';
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }


    public function changePageTitle($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);

		$session = $this->request->data('session');
		if( $this->checkSession($user_id, $session) ){
			$title = $this->request->data('title');
			if (is_null($title) || $title == ''){
				$res['msg'] = '文字を入力してください';
			} else {
				$update = array(
					'id' => $user_id,
					'title' => htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
				);
    	    	$this->User->save($update);
				$res['success'] = true;
				$res['msg'] = '変更しました';
			}
		} else {
			$res['msg'] = '認証に失敗しました';
		}

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }

    public function changePassword($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);
		$session = $this->request->data('session');
		if( $this->checkSession($user_id, $session) ){
			$password = $this->request->data('password');
			if (is_null($password) || $password == ''){
				$res['msg'] = '空のパスワードは登録できません';
			} else {
				if ($this->Str->validatePassword($password)) {
					$update = array(
						'id' => $user_id,
						'password' => $password,
					);
        			$this->User->save($update);
					$res['success'] = true;
					$res['msg'] = '変更しました';
				} else {
					$res['msg'] = '無効なパスワードです';
				}
			}//if
		} else {
			$res['msg'] = '認証に失敗しました';
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }


    private function checkSession($user_id,$session)
    {
        $users = $this->User->find('first', array(
            'fields'=>array('session'),
            'conditions'=>array('id'=>$user_id),
            ));
		return ($session == $users['User']['session']);
    }











    /*
     * カスタムランキング
     */
    public function ranking($userId)
    {
        $user_rankings = $this->UserRanking->find('all', array(
            'conditions'=>array('user_id' => $userId),
            'order'=>'id ASC'
            ));
        // １個もなかったら作成
        if (count($user_rankings) == 0) {
            $this->UserRanking->save(array(
                    'id'=>null,
                    'user_id'=>$userId,
                    'category'=>1,
                    'updated_at'=>date("y:m:d h:i:s")
                ),false);
            $this->UserRanking->save(array('id'=>null, 'user_id'=>$userId, 'category'=>9, 'updated_at'=>date("y:m:d h:i:s")),false);
            $this->UserRanking->save(array('id'=>null, 'user_id'=>$userId, 'category'=>18, 'updated_at'=>date("y:m:d h:i:s")),false);
            $this->UserRanking->save(array('id'=>null, 'user_id'=>$userId, 'category'=>19, 'updated_at'=>date("y:m:d h:i:s")),false);
            $this->UserRanking->save(array('id'=>null, 'user_id'=>$userId, 'category'=>24, 'updated_at'=>date("y:m:d h:i:s")),false);
            $this->UserRanking->save(array('id'=>null, 'user_id'=>$userId, 'category'=>31, 'updated_at'=>date("y:m:d h:i:s")),false);
            $user_rankings = $this->UserRanking->find('all', array(
                'conditions'=>array('user_id' => $userId),
                'order'=>'id ASC'
            ));
        }
        $categorys = array(
                array('id'=>0, 'name'=>''),
                array('id'=>1, 'name'=>'エンタメ・音楽'),
                array('id'=>2, 'name'=>' - エンターテイメント'),
                array('id'=>3, 'name'=>' - 音楽'),
                array('id'=>4, 'name'=>' - 歌ってみた'),
                array('id'=>5, 'name'=>' - 演奏してみた'),
                array('id'=>6, 'name'=>' - 踊ってみた'),
                array('id'=>7, 'name'=>' - VOCALOID'),
                array('id'=>8, 'name'=>' - ニコニコインディーズ'),
                array('id'=>9, 'name'=>'生活・一般・スポ'),
                array('id'=>10, 'name'=>' - 動物'),
                array('id'=>11, 'name'=>' - 料理'),
                array('id'=>12, 'name'=>' - 自然'),
                array('id'=>13, 'name'=>' - 旅行'),
                array('id'=>14, 'name'=>' - スポーツ'),
                array('id'=>15, 'name'=>' - ニコニコ動画講座'),
                array('id'=>16, 'name'=>' - 車載動画'),
                array('id'=>17, 'name'=>' - 歴史'),
                array('id'=>18, 'name'=>'政治'),
                array('id'=>19, 'name'=>'科学・技術'),
                array('id'=>20, 'name'=>' - 科学'),
                array('id'=>21, 'name'=>' - ニコニコ技術部'),
                array('id'=>22, 'name'=>' - ニコニコ手芸部'),
                array('id'=>23, 'name'=>' - 作ってみた'),
                array('id'=>24, 'name'=>'アニメ・ゲーム・絵'),
                array('id'=>25, 'name'=>' - アニメ'),
                array('id'=>26, 'name'=>' - ゲーム'),
                array('id'=>27, 'name'=>' - 東方'),
                array('id'=>28, 'name'=>' - アイドルマスター'),
                array('id'=>29, 'name'=>' - ラジオ'),
                array('id'=>30, 'name'=>' - 描いてみた'),
                array('id'=>31, 'name'=>'その他'),
                array('id'=>32, 'name'=>' - 例のアレ'),
                array('id'=>33, 'name'=>' - 日記'),
                array('id'=>34, 'name'=>' - その他'),
                );

        // 値をセット
        $this->set('user_rankings', $user_rankings);
        $this->set('categorys', $categorys);
        $this->set('user_id', $userId);
        $this->set('cakeDescription', '');
        $this->set('title_for_layout', 'にこまと！2.0');
    }

    /*
     * ランキング取得
     */
    public function apiGetRanking($categoryId, $mask = "")
    {
        $conditions = array(
            'type' => 2,
            'category' => $categoryId,
        );
        if ( $mask != "" ) {
            $aryMask = preg_split("/\s/", $mask);
            $temp = array();
            foreach ( $aryMask as $strMask ) {
                $temp[] = array('title NOT LIKE' => "%$strMask%");
            }
            $conditions[] = array( 'and' => $temp );
        }

        $rankings = $this->RankingNicovideo->find('all', array(
            'conditions' => $conditions,
            'order'=>'rank ASC',
        ));

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('rankings'));
        $this->set('_serialize','rankings');
    }

    /*
     * ユーザランキング更新
     */
    public function apiSetUserRanking($sessionId,$userId,$userRankingId,$categoryId,$mask="")
    {
        $res = array("success" => false);
        if ( $this->authSession($userId, $sessionId) )
        {
            $rankings = $this->UserRanking->updateAll(
                array('category'=>$categoryId, 'mask'=>"\"$mask\""),
                array('id'=>$userRankingId, 'user_id'=>$userId )
                );
            $res['success'] = true;
        }

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('rankings'));
        $this->set('_serialize','rankings');
    }


}
