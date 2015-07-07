<div id='navigation'>
	<ul>
		<li style='margin-right:4px;'>
			<img id='logo' src='/img/header/logo.png'>
		</li>
		<li>
			<a class='link_button' id='home_button' href='/'>
				<img src='/img/header/home.png'>
			</a>
		</li>
	<?php if(!($this->name==="User" && $this->action==="login") && $this->name!=="Register") : ?>
		<?php if($logged_in) : ?>
			<li>
				<a class='link_button' id='mypage_button' href='/user' style='margin-left:10px;'>
					<img src='/img/header/mypage.png'>
				</a>
			</li>
			<li>
				<a class='link_button' id='logout_button' href='/user/logout' style='margin-left:10px;'>
					<img src='/img/header/logout.png'>
				</a>
			</li>
		<?php else : ?>
			<li>
				<a class='link_button' id='login_button' href='/user/login' style='margin-left:10px;'>
					<img src='/img/header/login.png'>
				</a>
			</li>
			<li>
				<a class='link_button' id='register_button' href='/register' style='margin-left:10px;'>
					<img src='/img/header/register.png'>
				</a>
			</li>
		<?php endif; ?>
	<?php endif; ?>
	</ul>
</div>