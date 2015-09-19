<?php
App::uses('AppController', 'Controller');

class TopController extends AppController {

	public $uses = array('User','UserMylist','DataMylist');
	public $components = array('Str');

    /**
     * トップページ/ 新規登録
     */
    public function index() {
        // 値をセット
    }

    /**
     * 最新動画
     */
    public function latest($page = 1) {

		$mylists = $this->DataMylist->getList(
			array(),
			array(DATA_MYLIST_DATA_TYPE_MYLIST, DATA_MYLIST_DATA_TYPE_USER),
			$page,
			TOP_LATEST_LIST_LIMIT);

        // セット
		$this->set('mylists', $mylists);
		$this->set('page', $page);
		$this->set('page_max', 10);
    }

    /**
     * マイページ一覧
     */
    public function mypagelist($page = 1, $sort = null) {

		$mypages = $this->User->getList($page, TOP_MYPAGELIST_LIST_LIMIT, $sort);
		$mypage_count = $this->User->find('count');

        // セット
		$this->set(compact('mypages'));
		$this->set('page', $page);
		$this->set('page_max', ceil($mypage_count / TOP_MYPAGELIST_LIST_LIMIT));
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

		$title = $this->request->data('title');
		$url = $this->request->data('url');
		$password = $this->request->data('password');

		//var_dump($this->request->data);
		//return;

		if ($title == ''){
			$res['msg'] = 'ページ名が入力されていません';
		} else if($url == '') {
			$res['url'] = 'マイリストURLが入力されていません';
		} else {

			if (!$this->Str->validatePassword($password)){

				$res['url'] = '無効なパスワードです';

			} else {

				$user = array(
					'title'      => $title,
					'password'   => $password,
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
				);
				$this->User->save($user);
				$user_id = $this->User->getInsertID();
				$res['user_id'] = $user_id;
            
				$mylists = explode("\n", $url);
				foreach($mylists as $mylist)
				{
					$mylist_str = $this->Str->getMylistStr($mylist);
					$data_type = $this->Str->getDataType($mylist);
					if ($mylist_str != false){
						$data_mylist_id = $this->DataMylist->add($data_type, $mylist_str);
						$user_mylist = array(
							'user_id' => $user_id,
							'data_mylist_id' => $data_mylist_id,
							'check_flag' => 0,
							'delete_flag'=> 0,
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s"),
						);
						$this->UserMylist->save($user_mylist);
					}//if
				}//foreach
				$res['success'] = true;

			}

		}//if

        // 値をJSONで返す
        $this->viewClass = 'Json';
        $this->set(compact('res'));
		$this->set('_serialize','res');
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}


}
