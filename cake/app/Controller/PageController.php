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
		if($this->Session->read('from.login')) {
			$this->Session->delete('from.login');
			$this->redirect('index');
		}
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
	 * 天気表示ページ(javascriptからの読み込み専用)
	 */
	public function weather() {
		$this->set('title_for_layout', '天気 - ' . SERVICE_NAME);
	}

	/**
	 * キャンペーン情報表示ページ(javascriptからの読み込み専用)
	 */
	public function campaign() {
		$this->set('title_for_layout', 'キャンペーン - ' . SERVICE_NAME);
	}

	/**
	 * 共通エラー画面
	 */
	public function error() {
		$this->set('title_for_layout', 'エラー - ' . SERVICE_NAME);
	}
}
