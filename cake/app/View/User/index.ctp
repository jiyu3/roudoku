<article class="big">
	<div id="user_info" style="text-align:center;">
		<h2><?php echo 'ユーザ情報'; ?> </h2>
		<table  style="margin:0 auto;">
			<tr>
				<th><?php echo 'メールアドレス'; ?> </th>
				<td><?php echo $email; ?>　<a href="/user/edit_email"><?php echo '変更'; ?> </a></td>
			</tr>
			<tr>
				<th><?php echo '名前'; ?> </th>
				<td><?php echo $name; ?></td>
			</tr>
			<tr>
				<th><?php echo 'お知らせ情報'; ?> </th>
				<td><?php echo $send_ad_mail ? '受信する' : '受信しない'; ?></td>
			</tr>
		</table>
		<div>
			<?php if($paying) : ?>
				有料会員
			<?php else : ?>
				無料会員<br />
				<a href="<?php echo $this->Html->url("/payment", false); ?>">有料会員になる</a>
			<?php endif; ?>
		</div>
		<div class="links" style="margin-top:10px;">
			<a class="button" href="/user/edit" style="margin-left:auto; margin-right:auto;"><?php echo 'ユーザ情報を編集'; ?> </a>
		</div>
	</div>
</article>