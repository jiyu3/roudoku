<?php

App::uses('AppController', 'Controller');

class PageController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	/**
	 * ログインが必要なページを指定する。
	 * 該当ページに未ログイン状態でアクセスすると、
	 * /user/loginにリダイレクトされる。
	 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * プレイ画面にリダイレクトする。
	 */
	public function index() {
		if($this->Auth->loggedIn()) {
			$this->redirect('/play/index');
		} else {
			$this->redirect('/play');
		}
	}

	/**
	 * 特定商取引法に基づく表示
	 */
	public function law() {
		$this->set('title_for_layout', '特定商取引法に基づく表示 - ' . SERVICE_NAME);
	}

	/**
	 * 共通エラー画面
	 */
	public function error() {
		$this->set('title_for_layout', 'エラー - ' . SERVICE_NAME);
	}

	/**
	 * メンテナンス画面
	 */
	public function maintenance() {
		$this->set('title_for_layout', 'メンテナンス中 - ' . SERVICE_NAME);
	}
}
