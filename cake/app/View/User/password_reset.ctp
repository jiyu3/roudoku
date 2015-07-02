<style type="text/css">
	label {
		width: 120px;
	}
	
	.input, .submit {
		text-align: center;
	}
	
	input {
		margin-top: 20px;
	}
</style>

<article class="big">
	<?php if(isset($error)) : ?>
		<div style="margin-bottom:20px; text-align:center; color:red"><?php echo $error; ?></div>
	<?php else : ?>
		<div style="margin-bottom:20px; text-align:center;"><?php echo 'パスワード再設定用のURLを送りますので、登録したメールアドレスを入力してください。'; ?></div>
	<?php endif; ?>

	<?php 
		echo $this->Form->create('User',
			array(
				'url' => 'password_reset',
			)
		);
		echo $this->Form->input(
			'email',
			array(
					'type' => 'email',
					'label' => false,
					'style' => 'margin-top:0'
			)
		);
		echo $this->Form->end('メールを送信');
	?>
</article>