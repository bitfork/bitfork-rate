<h1><?php echo Yii::t('main', 'Bitfork-rate.com - индекс криптовалют'); ?></h1>
<p><a href="/">Bitfork-rate.com</a>  -  <?php echo Yii::t('main', 'бесплатный, настраиваемый сервис с открытым кодом, дающий вам возможность получать необходимые виды котировок на рынке криптовалют (биткоин, лайткоин и другие форк валюты). Настраиваемое по параметрам API.'); ?></p>

<?php echo $this->renderPartial('_rates', array('index'=>$data[$period]['index'],'range'=>$range,'data'=>$data[$period]['services'], 'pair'=>$pair)); ?>

<section class="main-separated-vertical">
	<h2><?php echo Yii::t('main', 'Бесплатный api для получения котировок криптовалют на вашем сайте'); ?></h2>
	<div id="index-rates" class="main-zoom">
		<article class="col-3">
			<div class="main-block_gray">
				<h4><?php echo Yii::t('main', 'Моментальный курс {cur_from}/{cur}', array('{cur_from}'=>$pair->currency_from->name,'{cur}'=>$pair->currency->name)); ?></h4>
				<p class="text-font_big"><?php echo ViewPrice::GetResult($data[0]['index']['index'], Currency::getSymbol($data[0]['index']['id_currency']), Currency::getCountRound($data[0]['index']['id_currency'])); ?></p>
			</div>
			<a class="btn-blue btn-block" href="javascript:showUrlApi('<?php echo $this->createAbsoluteUrl("/api/index/index", array("from"=>$pair->currency_from->name,"to"=>$pair->currency->name)); ?>");"><?php echo Yii::t('main', 'Сгенерировать код API'); ?></a>
		</article>

		<article class="col-3">
			<div class="main-block_gray">
				<h4><?php echo Yii::t('main', 'Средний курс за час {cur_from}/{cur}', array('{cur_from}'=>$pair->currency_from->name,'{cur}'=>$pair->currency->name)); ?></h4>
				<p class="text-font_big"><?php echo ViewPrice::GetResult($data[60]['index']['index'], Currency::getSymbol($data[60]['index']['id_currency']), Currency::getCountRound($data[60]['index']['id_currency'])); ?></p>
			</div>
			<a class="btn-blue btn-block" href="javascript:showUrlApi('<?php echo $this->createAbsoluteUrl("/api/index/index", array("from"=>$pair->currency_from->name,"to"=>$pair->currency->name,"period"=>60)); ?>');"><?php echo Yii::t('main', 'Сгенерировать код API'); ?></a>
		</article>

		<article class="col-3">
			<div class="main-block_gray">
				<h4><?php echo Yii::t('main', 'Средний курс за 24 часа {cur_from}/{cur}', array('{cur_from}'=>$pair->currency_from->name,'{cur}'=>$pair->currency->name)); ?></h4>
				<p class="text-font_big"><?php echo ViewPrice::GetResult($data[1440]['index']['index'], Currency::getSymbol($data[1440]['index']['id_currency']), Currency::getCountRound($data[1440]['index']['id_currency'])); ?></p>
			</div>
			<a class="btn-blue btn-block" href="javascript:showUrlApi('<?php echo $this->createAbsoluteUrl("/api/index/index", array("from"=>$pair->currency_from->name,"to"=>$pair->currency->name,"period"=>1440)); ?>');"><?php echo Yii::t('main', 'Сгенерировать код API'); ?></a>
		</article>
	</div>

	<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
</section>

<?php /*
<section class="main-bordered-vertical main-separated-vertical main-grid-380 main-grid380_bord main-block_grayLight">
	<div class="main-grid-sidebar_right">
		<?php echo $this->renderPartial('_link_project_form', array('model'=>$linkProject)); ?>
	</div>

	<div class="main-grid-content_left">
		<div class="main-padding_10">
			<h2><?php echo Yii::t('main', 'Нашим API уже пользуются:'); ?></h2>
			<ul class="main-listCol_2">
				<li><a href="#">bitfork-exchange.com</a></li>
				<li><a href="#">bitfork-exchange.com</a></li>
				<li><a href="#">bitfork-exchange.com</a></li>
				<li><a href="#">bitfork-exchange.com</a></li>
				<li><a href="#">bitfork-exchange.com</a></li>
				<li><a href="#">bitfork-exchange.com</a></li>
			</ul>
			<a href="#"><b><?php echo Yii::t('main', 'Посмотреть все сайты'); ?></b></a>
		</div>
	</div>
</section>
*/ ?>

<script language="javascript">
	function showUrlApi(url) {
		$('input[name="ApiExampleForm[api_example]"]').val(url);
		$('#form-submit-example').trigger('click');
	}
</script>

<?php
Yii::app()->clientScript->registerScriptFile('/themes/coin/assets/js/page.js', CClientScript::POS_END);
$js = 'Page.init('. $pair->id .', ChartMain);';
Yii::app()->clientScript->registerScript('page',$js);
Yii::app()->clientScript->registerScriptFile('/themes/coin/assets/js/ws.js', CClientScript::POS_END);
$js = 'WS.init();';
Yii::app()->clientScript->registerScript('ws',$js);
?>