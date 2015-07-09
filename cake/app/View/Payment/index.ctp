<script type="text/javascript">
	function showSubmit() {
		$('div.submit input, #save_card_info').fadeIn(200);
	}

	function hideSubmit() {
		$('div.submit input, #save_card_info').css('display', 'none');
	}

	function showCreditCardFrom() {
		$('#credit_card_form').fadeIn(200);
		hideSubmit();
	}

	function hideCreditCardFrom() {
		$('#credit_card_form').css('display', 'none');
		showSubmit();
	}

	function paymentConfirm() {
		var notice = '<?php echo '以下の内容で支払いを行います。よろしいですか？'; ?> \n\n' +
			'<?php echo '金額' . ': '; ?> ' + $('#PaymentAmount').val() + '<?php echo '円'; ?>\n' +
			'<?php echo '取得コンテンツ' . ': '; ?> ' + '「<?php echo SERVICE_NAME; ?>」有料コンテンツ利用料' + '\n' + 
			'<?php echo '課金形態' . ': '; ?> ' + '月額課金（自動継続）（毎月1日に当月分支払）' + '\n' +
			'<?php echo '課金開始日' . ': '; ?> ' + '「<?php echo SERVICE_NAME; ?>」有料コンテンツ利用料' + '\n';
		if(window.confirm(notice)) {
			$('#payment_submit').css('display', 'inline').prop('disabled', 'true').text('お待ちください');
			return true;
		}
		return false;
	}
</script>
<article>
	<h2>【クレジットカード情報を入力】</h2>
	<div id='available_cards'>
		<img src='/img/brands.png' width='30%' alt='<?php echo '利用可能カードは、VISA, MasterCard, JCB, Amex, DinersClubです。'; ?> ' />
	</div>

	<?php if(isset($error)) : ?>
		<p style="color:red;"><?php echo $error; ?></p>
	<?php endif; ?>

	<div id='price'>
		支払額: <?php echo $amount; ?>円（税込）
	</div>

	<?php
		echo $this->Form->create('Payment',
			array(
				'url' => "index",
				'inputDefaults' => array(
					'label' => false,
					'div' => array(
						'class' => 'payment_form'
					)
				),
				'onSubmit' => 'return paymentConfirm()'
			)
		);
		echo $this->Form->input(
			'amount',
			array(
				'type' => 'hidden',
				'default' => number_format($amount)
			)
		);
		echo $this->Form->input(
			'method',
			array(
				'type' => 'hidden',
				'default' => 'webpay'
			)
		);
	?>

	<span id="credit_card_form" class="check">
		<script src="https://checkout.webpay.jp/v2/" class="webpay-button"
			data-key="<?php echo $public_key; ?>" data-lang="ja" 
			data-partial="true" data-on-created="showSubmit">
		</script>
		<p id="due_date" class="check">
			<span style="color:red;">現在、初月108円キャンペーン中です。<br />2017年7月度は108円でサービスを利用できます。<br /></span>
			課金が終われば、すぐに利用可能です。<br />
			翌月以降は今回支払いをしたクレジットカードに自動的に課金されます。<br />
			自動課金のタイミングは、毎月１日です。
		</p>
	</span>
	<?php echo $this->Form->end(array('label'=>'支払を確定する', 'id'=>'payment_submit',  'style'=>'display:none;')); ?>
	<?php if($this->App->isMobile()) : ?>
		<a class="cancel" href="/"><?php echo 'トップページへ戻る';?></a>
	<?php endif; ?>
</article>