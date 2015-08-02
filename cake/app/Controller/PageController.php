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
	 * 朗読時に表示する画像をアップロードする。
	 */
	public function image() {
		$this->layout = 'admin';

		if($_SERVER['HTTP_HOST'] !== 'roudoku' && $_SERVER['HTTP_HOST'] !== '133.130.59.45') {
			$this->redirect('index');
		}

		if($this->request->is('post')) {
			$event = '';
			foreach($_FILES['image']['size'] as $key => $file) {
				if(empty($file)) {
					continue;
				}
				$img_name = $_POST['title']. "_" . sprintf("%03d", $key+1) . '.png';
				move_uploaded_file($_FILES['image']['tmp_name'][$key],
						"audio/event/{$img_name}");
	 			$event .= "evnt[{$key}] = {'start':'', 'end':'', 'img_path':'', 'audio_id':''};\n";
				$event .= "evnt[{$key}]['start'] = '" . $_POST["image_start"][$key] . "';\n";
				$event .= "evnt[{$key}]['end'] = '" . $_POST["image_end"][$key] . "';\n";
				$event .= "evnt[{$key}]['img_path'] = '/audio/event/{$img_name}';\n";
				$event .= "evnt[{$key}]['audio_id'] = '';\n";
			}
			file_put_contents("audio/event/{$_POST['title']}_".AUDIO_BOOKS_FOLDER_NAME."_frame.event", $event, LOCK_EX);

			$this->set('result', true);
			return true;
		}

		$files = $this->getFileList("audio/".AUDIO_BOOKS_FOLDER_NAME);
		$titles = array();
		foreach($files as $file) {
			if(substr($file, -5, 5) === 'title') {
				$titles[basename($file, '.title')] = trim(file_get_contents($file));
			}
		}
		$this->set('titles', $titles);
	}

	/**
	 * オーディオブックフォルダ及びイベントフォルダを初期化する（羅生門、ごん狐は残す）
	 */
	public function init($target = null) {
		if($_SERVER['HTTP_HOST'] !== 'roudoku' && $_SERVER['HTTP_HOST'] !== '133.130.59.45') {
			$this->redirect('index');
		}

		if($target === null) {
			$this->redirect('/');
		}

		if($target === 'upload') {
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

		if($target === 'image') {
			$files = $this->getFileList(getcwd().'/audio/event');
			foreach($files as $file) {
				$f = basename($file);
				$p1 = preg_match("/gongitune/", $f);
				$p2 = preg_match("/rashomon/", $f);
				if(!$p1 && !$p2) {
					unlink($file);
				}
			}
		}
	}

	/**
	 * PC用ヘルプ画面
	 */
	public function help() {
		$this->set('title_for_layout', 'ヘルプ - ' . SERVICE_NAME);
	}

	/**
	 * 共通エラー画面
	 */
	public function error() {
		$this->set('title_for_layout', 'エラー - ' . SERVICE_NAME);
	}
}
