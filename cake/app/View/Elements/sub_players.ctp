<div id='sub_players'>
	<?php foreach($audio as $key => $audio_path) : ?>
		<?php if($key === 'BGM') : ?>
			<audio id='<?php echo $key; ?>' loop>
				<source src="https://133.130.55.52<?php echo $audio_path; ?>" type="audio/mp4">
			</audio>
			<?php continue; ?>
		<?php endif; ?>
		<?php if($key === 'ending') : ?>
			<audio id='ending'>
				<source src="https://133.130.55.52<?php echo $audio_path; ?>" type="audio/mp4" onpause='showImage(1, 1, "sit", "none");'>
			</audio>
			<?php continue; ?>
		<?php endif; ?>
		<?php if($key !== AUDIO_BOOKS_FOLDER_NAME) : ?>
			<audio id='<?php echo $key; ?>'>
				<source src="https://133.130.55.52<?php echo $audio_path; ?>" type="audio/mp4">
			</audio>
		<?php endif; ?>
	<?php endforeach; ?>
</div>