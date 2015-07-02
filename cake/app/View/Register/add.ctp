<article class="big">
	<h2><?php echo '新規登録'; ?> </h2>
	<?php if(isset($error)) : ?>
		<?php echo $error . '<br>'; ?>
	<?php endif; ?>
	<?php	
		echo $this->Form->create('User', 
			array(
				'url' => 'add/?key=' . $regist_key,
				'inputDefaults' => array(
						'label' => 'ユーザ情報入力',
				),
				'onSubmit' => 'return userConfirm();'
			)
		);
		echo $this->Form->input(
			'name',
			array(
				'type' => 'text',
				'label' => 'お名前'
			)
		);
		echo $this->Form->input(
			'email',
			array(
				'type' => 'email',
				'label' => 'メールアドレス',
				'default' => $email,
				'disabled' => 'disabled'
			)
		);
		echo $this->Form->input(
			'password',
			array(
				'type' => 'password',
				'label' => 'パスワード',
				'default' => ''
			)
		);
		echo $this->Form->input(
			'send_ad_mail',
			array(
				'type' => 'checkbox',
				'label' => 'お知らせメールを受信する',
				'default' => true
			)
		);
		echo $this->Form->end('この内容で新規登録する');
	?>
</article>