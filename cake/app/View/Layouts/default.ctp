<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('favicon.ico', '/img/favicon.ico', array('type'=>'icon'));
		$css_prefix = $this->App->isMobile() ? 'mobile/' : '';
		echo $this->Html->css("{$css_prefix}common");
		echo $this->Html->css($css_prefix.strtolower($this->name));
		echo $scripts_for_layout;
		echo $this->Html->script('jquery-2.1.3.min');
		echo $this->Html->script('jquery.cookie.min');
		echo $this->Html->script('jquery.balloon.min');
		echo $this->Html->script('jquery.quicksearch.min');
		echo $this->Html->script('common.js');
	?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<meta property="og:title" content="<?php echo SERVICE_NAME; ?>">
	<meta property="og:url" content="https://<?php echo $_SERVER['SERVER_NAME']; ?>.jp/">
	<meta property="og:site_name" content="<?php echo SERVICE_NAME; ?>">
	<meta property="og:email" content="<?php echo COMPANY_EMAIL; ?>">
	<meta property="og:phone_number" content="050-5585-1095">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php include_once(APP . 'Vendor/analyticstracking.php'); ?>
</head>
<body>
	<div id="content">
	<?php if(!$this->App->isMobile() && !(isset($_GET['header']) && $_GET['header']==='none')) : ?>
 		<header>
			<?php echo $this->element('header'); ?>
		</header>
	<?php endif; ?>
		<div id="main">
			<?php echo $content_for_layout; ?>
		</div>
	<?php if($this->name==="Play" && $this->action==="index") : ?>
		<?php echo $this->element('sns'); ?>
		<div style="text-align: center; clear:both;">
			※現在、オープンテスト中です。不具合がありましたら、<a href='mailto:info@noumenon.jp'>info@noumenon.jp</a> までメールにてご連絡下さい。
		</div>
	<?php endif; ?>
	<?php if(!$this->App->isMobile()) : ?>
		<footer>
			<?php echo $this->element('footer'); ?>
		</footer>
	<?php endif; ?>
	</div>
 </body>
</html>