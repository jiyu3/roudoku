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
		$this->Security->csrfCheck = false;
		$this->Security->csrfUseOnce = false;
		$this->Security->validatePost = false;
		$this->Security->unlockedActions = array('upload', 'init');

		if($this->Session->read('from.login')) {
			$this->Session->delete('from.login');
			$this->redirect('index');
		}

		if(env('HTTPS')) {
			$this->redirect('http://' . env('SERVER_NAME') . $this->here);
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
	 * キャンペーン情報表示ページ(javascriptからの読み込み専用)
	 */
	public function campaign() {
		$this->set('title_for_layout', 'キャンペーン - ' . SERVICE_NAME);
	}

	/**
	 * 管理用画面。オーディオブックファイル等をアップロードする。
	 */
	public function upload() {
		if($_SERVER['HTTP_HOST'] !== 'roudoku' && $_SERVER['HTTP_HOST'] !== '133.130.59.45') {
			$this->redirect('index');
		}

		if($this->request->is('post')) {
			foreach($_FILES['userfile']['size'] as $key => $file) {
				if(empty($file)) {
					continue;
				}
				move_uploaded_file($_FILES['userfile']['tmp_name'][$key],
					"audio/".AUDIO_BOOKS_FOLDER_NAME."/{$_FILES['userfile']['name'][$key]}");
			}
	
			if(!empty($_POST['twitter_link']) && !empty($_FILES['userfile']['name'][0])) {
				preg_match("/(.+)(_\d{3})?\./", $_FILES['userfile']['name'][0], $match);
				$url = $_POST["twitter_link"];
				$affiliate_txt = "<a href='{$url}'>ツイートみてくださいね。</a>";
				file_put_contents("audio/ending/{$match[1]}.affiliate", $affiliate_txt, LOCK_EX);
			}
			$this->set('result', true);
		}
	}

	/**
	 * オーディオブックフォルダを初期化する（羅生門、ごん狐、羅生門体験版は削除する）
	 */
	public function init() {
		if($_SERVER['HTTP_HOST'] !== 'roudoku' && $_SERVER['HTTP_HOST'] !== '133.130.59.45') {
			$this->redirect('index');
		}
		$files = $this->getFileList(getcwd().'/audio/'.AUDIO_BOOKS_FOLDER_NAME);
		foreach($files as $file) {
			$f = basename($file);
			$p1 = preg_match("/gongitune/", $f);
			$p2 = preg_match("/rashomon/", $f);
			if(!$p1 && !$p2) {
				unlink($file);
			}
		}
	}
	

	/**
	 * 共通エラー画面
	 */
	public function error() {
		$this->set('title_for_layout', 'エラー - ' . SERVICE_NAME);
	}
}
