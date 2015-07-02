<?php if($this->App->isMobile()) : ?>
	<div style="text-align: center; margin-top:10px; margin-bottom: 10px;">
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://roudokushoujo.com" data-text="朗読少女Web版" data-via="otohashiori" data-hashtags="roudokushoujo">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

		<div id="facebook_post" style="margin-top:10px; width:100px;">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.3&appId=1450212918616270";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-like" data-href="https://roudokushoujo.com" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	</div>
<?php else : ?>
	<div style="text-align: center; margin-top:10px; margin-bottom: 10px;">
		<div id="twitter_post" style="float:left; width:175px; margin-left:30%;">
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://roudokushoujo.com" data-text="朗読少女Web版" data-via="otohashiori" data-hashtags="roudokushoujo">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</div>
	
		<div id="facebook_post" style="margin-left:-30px; float:left; width:100px;">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.3&appId=1450212918616270";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-like" data-href="https://roudokushoujo.com" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
	</div>
<?php endif; ?>