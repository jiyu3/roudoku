<div id='navigation'>
	<ul id='navigation_links'>
		<li>
			<div class='link_button'>
				<a href='<?php echo Router::url('/'); ?>'>ホーム</a>
			</div>
		</li>
	</ul>
	<?php if(!($this->name==="User" && $this->action==="login") && $this->name!=="Register") : ?>
		<ul id='navigation_functions'>
			<?php if($logged_in) : ?>
				<li>
					<div class='link_button'>
						<a href='<?php echo Router::url('/') . 'user'; ?>'>MyPage</a>
					</div>
				</li>
				<li>
					<div class='link_button' id='logout_button'>
						<a href='<?php echo Router::url('/') . 'user/logout'; ?>'>Logout</a>
					</div>
				</li>
			<?php else : ?>
				<li>
					<div class='link_button' id='login_button'>
						<a href='<?php echo Router::url('/') . 'user/login'; ?>'>ログイン</a>
					</div>
				</li>
				<li>
					<div class='link_button'>
						<a href='<?php echo Router::url('/') . 'register'; ?>'>新規登録</a>
					</div>
				</li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>
	<span></span>
</div>