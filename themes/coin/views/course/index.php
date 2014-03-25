<?php echo $this->renderPartial('_rates', array('index'=>$data[$period]['index'],'range'=>$range,'data'=>$data[$period]['services'])); ?>

<div class="rates-block">
	<div class="rate-block">
		<div class="rate-wrap">
			<h3 class="rate-caption bold">Моментальный курс</h3>
			<p class="currency"><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></p>
			<p class="rate">
				<?php echo ViewPrice::GetResult($data[0]['index']['index'], Currency::getSymbol($data[0]['index']['id_currency']), Currency::getCountRound($data[0]['index']['id_currency'])); ?>
			</p>
		</div>
		<a href="javascript:showUrlApi('<?php echo $this->createAbsoluteUrl('/api/index/index', array('from'=>$pair->currency_from->name,'to'=>$pair->currency->name)); ?>');" class="btn btn-default btn-block">Сгенерировать API код</a><br />
		<a href="" class="hint-link">Как рассчитывается?</a>
	</div>
	<div class="rate-block">
		<div class="rate-wrap">
			<h3 class="rate-caption bold">Средний за час</h3>
			<p class="currency"><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></p>
			<p class="rate">
				<?php echo ViewPrice::GetResult($data[1]['index']['index'], Currency::getSymbol($data[1]['index']['id_currency']), Currency::getCountRound($data[1]['index']['id_currency'])); ?>
			</p>
		</div>
		<a href="javascript:showUrlApi('<?php echo $this->createAbsoluteUrl('/api/index/index', array('from'=>$pair->currency_from->name,'to'=>$pair->currency->name,'period'=>1)); ?>');" class="btn btn-default btn-block">Сгенерировать API код</a><br />
		<a href="" class="hint-link">Как рассчитывается?</a>
	</div>
	<div class="rate-block">
		<div class="rate-wrap">
			<h3 class="rate-caption bold">Средний за 24 часа</h3>
			<p class="currency"><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></p>
			<p class="rate">
				<?php echo ViewPrice::GetResult($data[24]['index']['index'], Currency::getSymbol($data[24]['index']['id_currency']), Currency::getCountRound($data[24]['index']['id_currency'])); ?>
			</p>
		</div>
		<a href="javascript:showUrlApi('<?php echo $this->createAbsoluteUrl('/api/index/index', array('from'=>$pair->currency_from->name,'to'=>$pair->currency->name,'period'=>24)); ?>');" class="btn btn-default btn-block">Сгенерировать API код</a><br />
		<a href="" class="hint-link">Как рассчитывается?</a>
	</div>
</div>

<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>

<div class="main-aboutus-block">
	<h4 class="text-black bold">О битфорк индексе криптовалют.</h4>
	<p class="text-black">Бесплатный, настраиваемый сервис <b>с открытым кодом</b>, дающий вам возможность получать необходимые виды котировок на рынке криптовалют (биткоин, лайткоин и другие форк валюты). Настраиваемое по параметрам API.</p>
</div>

<script language="javascript">
	function showUrlApi(url) {
		$('input[name="ApiExampleForm[api_example]"]').val(url);
	}
</script>