<style text="text/css">
	input {
		margin-left: 20px;
	}
	
	div.submit input {
		margin-left: 20px;
	}
</style>

<article class="big" style="text-align: center;">
	<p><?php echo '新規登録を行います。お使いのメールアドレスを入力してください。'; ?> </p>
	<?php if(isset($error)) : ?>
		<div style="color:red; margin-top: 20px;">
			<?php echo $error . '<br>'; ?>
		</div>
	<?php endif; ?>
	<?php
		echo $this->Form->create('ProvisionalRegistration',
			array(
				'url' => 'index',
			)
		);
		echo $this->Form->input(
			'email',
			array(
				'type' => 'email',
				'label' => false,
				'style' => 'margin-top: 20px;'
			)
		);
		echo $this->Form->end('新規登録する');
	?>
</article>
	