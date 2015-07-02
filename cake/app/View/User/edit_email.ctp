<article class="big" style="text-align:center;">
	<h2 style="text-align:center;"><?php echo 'メールアドレスの変更'; ?> </h2>
	<p><?php echo '新しいメールアドレスを以下に入力してください。'; ?> </p>
	<?php if(isset($error)) : ?>
		<p style="color:red;"><?php echo $error; ?></p>
	<?php endif; ?>
	<?php
		echo $this->Form->create('User',
			array(
				'url' => 'edit_email',
				'inputDefaults' => 
				array(
					'label' => false,
				),
			)
		);
		echo $this->Form->input(
			'regist_email',
			array(
				'type' => 'email',
				'required' => 'required'
			)
		);
		echo $this->Form->end('変更する');
	?>
	<a class="cancel" href="/user/index"><?php echo 'ユーザ情報ページに戻る'; ?> </a>
</article>