<article>
	<h2>【アップロード】</h2>
	<?php if(isset($result)) : ?>
		<p>アップロードが完了しました。次に <a href='/play/make'>こちらをクリックして</a>wavを変換して下さい。</p>
	<?php else : ?>
		<?php if(isset($error)) : ?>
			<span style="color:red;"><?php echo $error; ?></span>
		<?php endif; ?>	
		<form action="/page/upload" method="post" enctype="multipart/form-data">
			<p>str, m4a, wav, txtを順にアップロードしてください:</p>
			<input name="userfile[]" type="file" /><br />
			<input name="userfile[]" type="file" /><br />
			<input name="userfile[]" type="file" /><br />
			<input name="userfile[]" type="file" /><br /><br />
			<p>読後にしおりちゃんが吹き出しで喋るTwitterのURLを入力して下さい（任意）:</p>
			<input name="twitter_link" type="url" placeholder='関連twitterのURLを入力' /><br />
			<p>必要項目を全て入れ終わったら、アップロードしてください:</p>
			<input type="submit" value="ファイルをアップロード" />
		</form>
	<?php endif; ?>
</article>