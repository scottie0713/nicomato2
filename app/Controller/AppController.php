<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $uses = array('LogAccessPage', 'DataAd');

	public function beforeFilter(){
		// キャッシュ無効
		$this->response->disableCache();
		// PC/モバイル判定
		if ($this->request->is('mobile')) {
			$this->theme = 'Smartphone';
		}
		// accessログ保存
		$this->LogAccessPage->save(
			array(
				'controller' => $this->name,
				'action'     => $this->action,
				'param'      => (isset($this->params->pass[0]))? $this->params->pass[0] : null,
				'created_at' => date("Y-m-d H:i:s"),
			)
		);
		// 広告取得(amazon/dmm)
		$ad_amazon = $this->DataAd->get(($this->request->is('mobile'))?2:1, 'amazon');
		$ad_dmm = $this->DataAd->get(($this->request->is('mobile'))?2:1, 'dmm');
		$this->set('ad_amazon', $ad_amazon);
		$this->set('ad_dmm', $ad_dmm);
	}//function

}
