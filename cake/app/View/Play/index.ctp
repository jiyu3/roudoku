<?php
	$i = 0;
	$onclick_text = array();
	foreach($titles as $filename => $title) {
		$onclick_text[] = '$("#"+"'.AUDIO_BOOKS_FOLDER_NAME.'")'.
			'.attr("src", "'.'/audio/'.AUDIO_BOOKS_FOLDER_NAME.'/'.$filename.'.m4a'.'");'.
			'skip(); refresh("'.$filename.'");'.
			'document.title = "朗読少女 - '.$title.'";'.
			'document.getElementById(audio_books_folder_name).load();'.
			'audio["ending"].load(); var a;'.
			'for(key in evnt) {'.
			'	a = document.getElementById(evnt[key]["audio_id"]);'.
			'	if(a) {'.
			'		a.load();'.
			'	}'.
			'}'.							
			'if(is_mobile) {'.
			'	$("#sidebar, #setting_close").fadeOut();'.
			'}'.
			'document.getElementById(audio_books_folder_name).play();';
	}
?>

<button type='button' id='loading'>
	<?php echo $this->Html->image('loading.gif', array('alt'=>'loading')); ?>
</button>
<?php echo $this->Html->image('bumper.png', array('id'=>'bumper')); ?>
<?php
	if($this->App->isMobile()) {
		echo $this->Html->image('window_open.png',
			array('id'=>'setting_open', 'onclick'=>"$('.balloon').hideBalloon(); $('#sidebar, #setting_close').fadeIn();"));
		echo $this->Html->image('window_close.png',
			array('id'=>'setting_close', 'onclick'=>"$('#sidebar, #setting_close').fadeOut();"));
	}
?>
<input class='no_disabled' id='skip' type='image' src='<?php echo Router::url('/', false); ?>img/skip.png' onclick='skip();'>
<div id='main_screen'>
	<img id='main_background'>
	<img id='event_background'>
	<img id='chair'>

	<div class='character'>
	<?php echo $this->element('read_images_direct'); ?>
	</div>
	<?php echo $this->element('touch_body'); ?>

	<span id='clock' onClick='clock();'></span>
	<span id='affiliate'></span>

	<div id='audio_player'>
		<script type="text/javascript" src="<?php echo $this->Html->url("/mediaelement/mediaelement-and-player.min.js"); ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->url("/mediaelement/mediaelementplayer.min.css"); ?>">
	
		<div id='main_player'>
			<audio id='<?php echo AUDIO_BOOKS_FOLDER_NAME; ?>' controls="controls" onplay='start_reading();' onpause='stop_reading();' 
					onvolumechange="$('audio').prop('volume', this.volume); $.cookie('volume', this.volume);">
		 		<source src="<?php echo $audio[AUDIO_BOOKS_FOLDER_NAME]; ?>" type="audio/mp4">
				お客様のブラウザはhtml5 オーディオをサポートしておりません。最新のブラウザをご利用下さい。
			</audio>
		</div>
		<div class='reload'>
			<?php echo $this->element('sub_players'); ?>
		</div>
		<script type="text/javascript">
			$('audio').not('#<?php echo AUDIO_BOOKS_FOLDER_NAME; ?>').not('#bgm').attr({'onpause':"$('*').css('pointer-events', '');"});
		</script>
	</div>
	<div class='reload'>
		<?php echo $this->element('main_script', array('lip'=>$lip, 'fps'=>$fps, 'today'=>$today, 'current_filename'=>$current_filename, 'onclick_text'=>$onclick_text)); ?>
	</div>

	<div id='subtitles'></div>
</div>

<div id='sidebar'>
	<div id='audio_links'>
		<h3>オーディオブック一覧</h3>
		<input style='margin-left:20px;' type="text" name="search" value="" id="search" placeholder='検索' />
		<table>
			<tbody>
				<?php $i = 0; ?>
				<?php if($is_paying) : ?>
					<?php foreach($titles as $filename => $title) : ?>
						<tr><td id='a_<?php echo $i; ?>'>
							<a id='<?php echo $i; ?>' class='<?php echo $filename; ?>' onclick='<?php echo $onclick_text[$i++]; ?>'
								href='javascript:void(0);'><?php echo $title; ?></a></td></tr>
					<?php endforeach; ?>
				<?php else : ?>
					<?php foreach($titles as $title) : ?>
						<tr><td><span style='text-decoration:none; color:teal;'><?php echo "本のタイトル{$i}"; $i++; //$title; ?></span></td></tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?php if(!$is_paying) : ?>
		<script type='text/javascript'>
			$('#audio_links').animate({opacity:"0.2"});
		</script>
		<div id='recommendation'>
			<p id='recommend_text'><a href='<?php echo $this->Html->url("/payment"); ?>'>月々300円支払えば</a>、
			すべての朗読を聴くことができます。支払いは<a href='<?php echo $this->Html->url("/payment"); ?>'>こちら</a>で行えます。</p>
		</div>
	<?php endif; ?>
</div>