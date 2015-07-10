<?php

App::uses('AppController', 'Controller');

class PlayController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Payment', 'User');
	const DEFAULT_BOOK_TITLE = "羅生門（体験版）";
	const DEFAULT_BOOK_TITLE_LOGIN = "羅生門";
	const DEFAULT_BOOK_TITLE_PAYMENT = "ごん狐";
	public $fps = 8;

	public function beforeFilter() {
		if(isset($this->request->query['fps'])) {
			$this->fps = $this->request->query['fps'];
		}

		$this->set('title_for_layout', SERVICE_NAME);
		$this->set('is_paying', $this->Payment->isPaying($this->Auth->user('id')));
		parent::beforeFilter();
	}

	/**
	 * プレイ画面を表示する。
	 * @param string $title		オーディオブックのタイトル
	 */
	public function index($title = null) {
		if($this->Payment->isPaying($this->Auth->user('id'))) {
			if(!$title || $title===self::DEFAULT_BOOK_TITLE) {
				$this->redirect('index/' . self::DEFAULT_BOOK_TITLE_PAYMENT);
			}
		} else if($this->Auth->loggedIn()) {
			if($title !== self::DEFAULT_BOOK_TITLE_LOGIN) {
				$this->redirect('index/' . self::DEFAULT_BOOK_TITLE_LOGIN);
			}
		} else {
			if($title !== self::DEFAULT_BOOK_TITLE) {
				$this->redirect('index/' . self::DEFAULT_BOOK_TITLE);
			}
		}

		$this->set('title_for_layout', SERVICE_NAME . ' - ' . $title);
		$this->setAll($title);
	}
	
	public function make() {
		require APP . 'Vendor/wave.php';
		ini_set('memory_limit', -1);
		ini_set('max_execution_time', -1);
		$files = $this->getFileList('audio');
		foreach($files as &$file) {
			if(substr($file, -3, 3) === 'wav') {
				new Wave($file);
				echo "'{$file}' has been converted.<br />";
				unlink($file);
			}

			if(substr($file, -3, 3) === 'srt') {
				$subtitles = $this->formatSubtitles(file($file));
				$result = "subtitles = {
					'page':JSON.parse('{$subtitles['page']}'),
					'start':JSON.parse('{$subtitles['start']}'),
					'end':JSON.parse('{$subtitles['end']}'),
					'text':JSON.parse('{$subtitles['text']}')
				};";
				file_put_contents('audio/'.AUDIO_BOOKS_FOLDER_NAME.'/'.basename($file, ".srt").'.subtitles', $result);
				echo "'{$file}' has been converted.<br />";
			}

			if(substr($file, -3, 3) === 'txt') {
				rename($file, 'audio/'.AUDIO_BOOKS_FOLDER_NAME.'/'.basename($file, ".txt").'.title');
				echo "'{$file}' has been converted.<br />";
			}
		}
		$this->redirect('index');
	}

	/**
	 * オーディオファイル（のリンクテキスト）、口パクのJSONデータ、オーディオファイルのタイトル一覧をビューにセットする。
	 * @param string $title	そのページで表示すべきオーディオファイルのタイトル
	 */
	private function setAll($title) {
		$current_filename = '';
		$files = $this->getFileList("audio/".AUDIO_BOOKS_FOLDER_NAME);
		foreach($files as $file) {
			if(substr($file, -5, 5) === 'title') {
				$content = file_get_contents($file);
				if($content === $title) {
					$current_filename = basename($file, '.title');
				}
				$titles[basename($file, '.title')] = file_get_contents($file);
			}
		}
		if(!$title || !file_exists('audio/' . AUDIO_BOOKS_FOLDER_NAME . '/' . $current_filename . '.m4a')) {
			$this->redirect('index');
		}
		unset($titles[array_search(self::DEFAULT_BOOK_TITLE, $titles)]);

		$files = $this->getFileList("audio");
		$today = date("n_j");
		foreach($files as $file) {
			if(end((explode('/', dirname($file)))) === AUDIO_BOOKS_FOLDER_NAME) {
				continue;
			} else if(end((explode('/', dirname($file)))) === 'today') {
				$lip['today'] = '/audio/today/date_'.date("n_j").'.json';
				$audio['today'] = '/audio/today/date_'.date("n_j").'.m4a';
			} else {
				if(substr($file, -4, 4) === 'json') {
					$lip[basename($file, ".json")] = '/' . $file;
				}
				if(substr($file, -3, 3) === 'm4a') {
					$audio[basename($file, ".m4a")] = '/' . $file;
				}
			}
		}
		$audio[AUDIO_BOOKS_FOLDER_NAME] = Router::url('/', false) . 'audio/' . AUDIO_BOOKS_FOLDER_NAME . '/' . $current_filename . '.m4a';
		$lip[AUDIO_BOOKS_FOLDER_NAME] = Router::url('/', false) . 'audio/' . AUDIO_BOOKS_FOLDER_NAME . '/' . $current_filename . '.json';

		asort($titles);
		$this->set('is_mobile', $this->isMobile());
		$this->set('fps', $this->fps);
		$this->set('lip', $lip);
		$this->set('audio', $audio);
		$this->set('current_filename', $current_filename);
		$this->set('titles', $titles);
	}

	/**
	 * 字幕ファイルを読み込み、利用可能な形に整形する。
	 * @param string subtitles	整形対象の字幕データ
	 */
	private function formatSubtitles($subtitles) {
		$result = array();
		foreach($subtitles as $key => &$value) {
			if($key%4 === 0) {
				$result['page'][] = rtrim($value);
			}
			if($key%4 === 1) {
 				$result['start'][] = $this->toMsec(substr($value, 0, 12));
 				$result['end'][] = $this->toMsec(substr($value, 17, 12));
			}
			if($key%4 === 2) {
				$result['text'][] = rtrim($value);
			}
		}
		return array(
			'page' => json_encode($result['page']),
			'start' => json_encode($result['start']),
			'end' => json_encode($result['end']),
			'text' => json_encode($result['text'], JSON_UNESCAPED_UNICODE)
		);
	}

	/**
	 * hh:mm:ss:mmm 形式のファイルを、指定の秒数に変換する。
	 * @param  string $time	hh:mm:ss:mmm 形式の文字列
	 * @return string ミリ秒数
	 */
	private function toMsec($time) {
		$hour = (int)substr($time, 0, 2);
		$min = (int)substr($time, 3, 2);
		$sec = (int)substr($time, 6, 2);
		$msec = (int)substr($time, 9, 3);
		return (string)($hour*60*60*1000 + $min*60*1000 + $sec*1000 + $msec);
	}
}