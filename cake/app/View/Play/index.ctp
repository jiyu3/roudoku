<?php
	$i = 0;
	$onclick_text = array();
	foreach($titles as $filename => $title) {
		$onclick_text[] = '$("#"+"'.AUDIO_BOOKS_FOLDER_NAME.'")'.
			'.attr("src", "'.'/audio/'.AUDIO_BOOKS_FOLDER_NAME.'/'.$filename.'.m4a'.'");'.
			'skip(); refresh("'.$filename.'");'.
			'document.title = "'.SERVICE_NAME.' - '.$title.'";'.
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
			'document.getElementById(audio_books_folder_name).play();'.
			'url = "https://'.$_SERVER['SERVER_NAME'].'/play/index/'.$title.'"';
	}
?>

<button type='button' id='loading'>
	<?php echo $this->Html->image('loading.gif', array('alt'=>'loading')); ?>
	<img src='' id='loaded' onmouseover='$(this).css("opacity", 0.7);' onmouseout='$(this).css("opacity", 1);'>
</button>
<?php echo $this->Html->image('bumper.png', array('id'=>'bumper')); ?>
<?php
	if($is_mobile) {
		echo $this->Html->image('window_open.png',
			array('id'=>'setting_open', 'onclick'=>"$('.balloon').hideBalloon(); $('#sidebar, #setting_close').fadeIn();"));
		echo $this->Html->image('window_close.png',
			array('id'=>'setting_close', 'onclick'=>"$('#sidebar, #setting_close').fadeOut();"));
		echo $this->Html->image('user.png',
			array('id'=>'user', 'onclick'=>"location.href='/user'"));
	}
?>
<input class='no_disabled' id='skip' type='image' src='<?php echo Router::url('/', false); ?>img/skip.png' onclick='skip();'>
<div id='main_screen'>
	<img id='main_background'>
	<img id='event_background'>
	<img id='chair'>

	<?php echo $this->element('sns'); ?>

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
		<?php echo $this->element('sub_players'); ?>
		<script type="text/javascript">
			$('audio').not('#<?php echo AUDIO_BOOKS_FOLDER_NAME; ?>').not('#bgm').attr({'onpause':"$('*').css('pointer-events', '');"});
		</script>
	</div>
	<div class='reload'>
		<?php echo $this->element('main_script', array('lip'=>$lip, 'fps'=>$fps, 'current_filename'=>$current_filename, 'onclick_text'=>$onclick_text)); ?>
	</div>

	<div id='subtitles'></div>
</div>

<div id='sidebar'>
	<div id='audio_links'>
		<h3>
			<?php if($is_mobile) : ?>
				【オーディオブック一覧】
			<?php else : ?>
				<img src='/img/audio_list.png'>
			<?php endif; ?>
		</h3>
		<?php if($is_mobile) : ?>
			<input style='margin-left:20px;' type="text" name="search" value="" id="search" placeholder='検索' />
		<?php endif; ?>
		<table>
			<tbody>
				<?php $i = 0; ?>
				<?php if($is_paying) : ?>
					<?php foreach($titles as $filename => $title) : ?>
						<tr><td id='a_<?php echo $i; ?>'>◆<a id='<?php echo $i; ?>' class='<?php echo $filename; ?> no_pjax audio_title' onclick='<?php echo $onclick_text[$i++]; ?>'
								href='javascript:void(0);'><?php echo $title; ?></a></td></tr>
					<?php endforeach; ?>
				<?php else : ?>
					<?php foreach($titles as $title) : ?>
						<tr><td>◆<span class='audio_title'><?php echo $title; ?></span></td></tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
			<script type='text/javascript'>
				$('.audio_title').each(function(){
					$(this).html($(this).html().replace(/~\d{3}~/g, "　"));
				});
			</script>
		</table>
	</div>
	<?php if(!$is_paying) : ?>
		<script type='text/javascript'>
			$('#audio_links').animate({opacity:"0.2"});
		</script>
		<div id='recommendation'>
			<p id='recommend_text'><a href='<?php echo $this->Html->url("/payment"); ?>'>月々300円で</a>、<br />
			全ての朗読を聴くことができます。<br />手続きは<a href='<?php echo $this->Html->url("/payment"); ?>'>こちら</a>で行えます。</p>
		</div>
	<?php endif; ?>
	<div id='affiliate_links'>
		affiliate一覧
	</div>
</div>