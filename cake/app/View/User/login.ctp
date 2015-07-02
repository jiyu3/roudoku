<article>
	<div>
		<?php if(isset($error)) : ?>
			<div style="color:red;">
				<?php echo $error; ?>
			</div>
		<?php endif; ?>
		<?php echo $this->Form->create('User'); ?>
			<fieldset>
				<?php
					echo $this->Form->input(
						'email',
						array(
							'type' => 'text',
							'label' => __('メールアドレス'),
						)
					);
					echo $this->Form->input(
						'password',
						array(
							'type' => 'password',
							'label' => __('パスワード'),
						)
					);
					echo $this->Form->input(
						'remember_me',
						array(
							'type' => 'checkbox',
							'label' => __('ログインしたままにする'),
						)
					);
				?>
			</fieldset>
		<?php echo $this->Form->end(__('ログイン')); ?>
		<div>
			<a href="/user/password_reset"><?php echo __('パスワードを忘れた方はこちら'); ?></a>
		</div>
	</div>
	<div>
		<?php echo __('ユーザ登録をされていない方はこちら'); ?>
		<a href="/register/index" class="register"><?php echo __('新規登録'); ?></a>
	</div>
</article>