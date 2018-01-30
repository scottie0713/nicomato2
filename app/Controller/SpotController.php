<?php
App::uses('AppController', 'Controller');

/**
 * =============================================
 *
 * SpotController
 * ユーザ毎のページ表示
 *
 * =============================================
 */
class SpotController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $uses = array('SpotUser', 'SpotUserCategory', 'SpotUserMovie');
	public $components = array('Str', 'Cookie');

    public function index()
	{
		// 値をセット
		//$this->set(compact());
    }

    /**
     * マイページ一覧
     */
    public function mypagelist($page = 1, $sort = null)
	{
		$mypages      = $this->SpotUser->getList($page, TOP_MYPAGELIST_LIST_LIMIT, $sort);
		$mypage_count = $this->SpotUser->find('count');

        // セット
		$this->set(compact('mypages'));
		$this->set('page', $page);
		$this->set('page_max', ceil($mypage_count / TOP_MYPAGELIST_LIST_LIMIT));
    }

    /**
     * マイページ
	 * @param user_id ユーザＩＤ
	 * @param page    ページ番号
     */
    public function mypage($user_id, $category_id = 0) {

		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		if (count($this->SpotUser->get($user_id)) == 0) {
			$this->redirect('/');
		}

		// user取得
        $users = $this->SpotUser->get($user_id);

		// category取得
		$tmp_categorys = $this->SpotUserCategory->getByUserId($user_id);
		$categorys     = array();
		foreach($tmp_categorys as $category)
		{
			$spot_category_id   = $category['SpotUserCategory']['id'];
			$spot_category_name = $category['SpotUserCategory']['name'];

			$categorys[$spot_category_id] = $spot_category_name;
		}
		unset($tmp_categorys);

		// movie取得
		$tmp_movies = $this->SpotUserMovie->get($user_id, $category_id);
		$movies     = array();
		foreach($tmp_movies as $movie)
		{
			$movies[] = $movie['SpotUserMovie'];
		}
		unset($tmp_movies);


		// 値をセット
		$this->set(compact('categorys', 'movies','user_id','users','category_id'));
    }

	/**
	 * 編集ページ
	 * @param user_id ユーザＩＤ
	 */
    public function setting($user_id)
    {
		// 無効なユーザＩＤならリダイレクト
		if (is_null($user_id) || $user_id == 0) {
			$this->redirect('/');
		}
		if (count($this->SpotUser->get($user_id)) == 0) {
			$this->redirect('/');
		}
		$user = $this->SpotUser->get($user_id);

		// category取得
		$tmp_categorys = $this->SpotUserCategory->getByUserId($user_id);
		$categorys     = array();
		foreach($tmp_categorys as $category)
		{
			$spot_category_id   = $category['SpotUserCategory']['id'];
			$spot_category_name = $category['SpotUserCategory']['name'];

			$categorys[$spot_category_id] = $spot_category_name;
		}
		unset($tmp_categorys);

		// movie取得
		$tmp_movies = $this->SpotUserMovie->getByUserId($user_id);
		$movies     = array();
		foreach($tmp_movies as $movie)
		{
			$movies[] = $movie['SpotUserMovie'];
		}
		unset($tmp_movies);

		//パスワード
		$password = '';
		if ($this->Cookie->read('session')) {
			$cookie_session = $this->Cookie->read('session');
			if ($cookie_session == $user['SpotUser']['session']) {
				$password = $user['SpotUser']['password'];
			}
		}

		// 値をセット
		$this->set(compact('categorys', 'movies','user_id','users'));
		$this->set('title',    $user['SpotUser']['title']);
		$this->set('password', $password);
    }

    /**
     * [API] マイページ作成
	 * @param post title セッション
	 * @param post url マイリスト/ユーザURL
	 * @param post password マイリスト/ユーザURL
     */
    public function regist()
    {
		$res = array(
			'success' => false,
			'msg'     => '',
			'user_id' => ''
		);

		$title    = $this->request->data('title');
		$password = $this->request->data('password');

		if($title == '')
		{
			$res['msg'] = 'ページ名が入力されていません';
		}
		if(!$this->Str->validatePassword($password))
		{
			$res['msg'] = '無効なパスワードです';
		}

		if($res['msg'] == '')
		{
			$user = array(
				'title'      => $title,
				'password'   => $password,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			);
			$this->SpotUser->save($user);
			$user_id        = $this->SpotUser->getInsertID();
			$res['user_id'] = $user_id;
			$res['success'] = true;
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
		$this->set('_serialize','res');
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
        $users = $this->SpotUser->get($user_id);
		if ($password == $users['SpotUser']['password']) {
			$res['success']                  = true;
			$res['session']                  = md5(date("YmdHis"));
			$users['SpotUser']['session']    = $res['session'];
			$users['SpotUser']['updated_at'] = date("Y-m-d H:i:s");
			$this->SpotUser->save($users);
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
							'check_flag' => 1,
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
    	    	$this->SpotUser->save($update);
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
        			$this->SpotUser->save($update);
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

    public function addCategory($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);
		$session = $this->request->data('session');
		if($this->checkSession($user_id, $session))
		{
			$name = $this->request->data('name');
			if (is_null($name) || $name == '')
			{
				$res['msg'] = '空文字のカテゴリは登録できません';
			}
			else
			{
				$name = htmlspecialchars($name);
				$this->SpotUserCategory->insert($user_id, $name);
				$res['success'] = true;
				$res['msg']     = '追加しました';
			}//if
		}
		else
		{
			$res['msg'] = '認証に失敗しました';
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }

    public function changeCategory($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);
		$session = $this->request->data('session');
		if( $this->checkSession($user_id, $session) )
		{
			$category_id = $this->request->data('id');
			$name = $this->request->data('name');
			if ($name == '')
			{
				$res['msg'] = '空文字のカテゴリは登録できません';
			}
			else 
			{
				$name = htmlspecialchars($name);
				$this->SpotUserCategory->update($category_id, $name);
				$res['success'] = true;
				$res['msg']     = '変更しました';
			}//if
		}
		else
		{
			$res['msg'] = '認証に失敗しました';
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }

    public function addMovie($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);
		$session = $this->request->data('session');
		if($this->checkSession($user_id, $session))
		{
			$movie_url   = $this->request->data('movie_url');
			$movie_str   = $this->Str->getMovieStr($movie_url);
			$min         = $this->request->data('min');
			$sec         = $this->request->data('sec');
			$comment     = $this->request->data('comment');
			$category_id = $this->request->data('category_id');
			if(!$movie_str)
			{
				$res['msg'] = '動画URLが不正です';
			}

			if(!preg_match("/^[0-9]+$/", $min)
			|| !preg_match("/^[0-9]+$/", $sec))
			{
				$res['msg'] = '時間が不正です';
			}
			$sec += $min * 60;

			if($category_id == 0)
			{
				$category_id = null;
			}

			if ($res['msg'] == '')
			{
				$api     = $this->SpotUserMovie->getMovieDataByApi($movie_str);
				$comment = htmlspecialchars($comment);
				$this->SpotUserMovie->insert(
						$user_id,
						$category_id,
						1,
						$movie_str,
						$api['title'],
						'',
						$comment,
						$sec,
						0);
				$res['success'] = true;
				$res['msg']     = '追加しました';
			}//if
		}
		else
		{
			$res['msg'] = '認証に失敗しました';
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }

    public function changeMovie($user_id)
    {
		$res = array(
			'success' => false,
			'msg' => ''
		);
		$session = $this->request->data('session');
		if($this->checkSession($user_id, $session))
		{
			$spot_movie_id = $this->request->data('id');
			$movie_url     = $this->request->data('movie_url');
			$movie_str     = $this->Str->getMovieStr($movie_url);
			$min           = $this->request->data('min');
			$sec           = $this->request->data('sec');
			$comment       = $this->request->data('comment');
			$category_id   = $this->request->data('category_id');
			if(!$movie_str)
			{
				$res['msg'] = '動画URLが不正です';
			}

			if(!preg_match("/^[0-9]+$/", $min)
			|| !preg_match("/^[0-9]+$/", $sec))
			{
				$res['msg'] = '時間が不正です';
			}
			$sec += $min * 60;

			if($category_id == 0)
			{
				$category_id = null;
			}

			if ($res['msg'] == '')
			{
				$api     = $this->SpotUserMovie->getMovieDataByApi($movie_str);
				$comment = htmlspecialchars($comment);
				$this->SpotUserMovie->update(
						$spot_movie_id,
						$category_id,
						$movie_str,
						$api['title'],
						'',
						$comment,
						$sec,
						0);
				$res['success'] = true;
				$res['msg']     = '変更しました';
			}//if
		}
		else
		{
			$res['msg'] = '認証に失敗しました';
		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
        $this->set('_serialize','res');
    }







    private function checkSession($user_id,$session)
    {
        $users = $this->SpotUser->find('first', array(
            'fields'=>array('session'),
            'conditions'=>array('id'=>$user_id),
            ));
		return ($session == $users['SpotUser']['session']);
    }

}
