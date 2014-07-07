<h1>Бесплатное API для получения курса криптовалют bitcoin, litecoin, vertcoin и еще 3 криптовалют</h1>
<p><b>Битфорк индекс криптовалют является бесплатным в использовании сервисом с открытым исходным кодом.</b> Вы всегда можете поднять
	свою копию на собственном сервере, но для вашего удобства мы выделили работающий 24/7 сервер, который способен справится с получаемыми
	от бирж данными. Мы следим за доступностью бифорк индекса с нашего сервера и постоянно работаем над оптимизацией его работы.</p>

<hr class="hr-double hr-bigMarg"/>
<section class="main-grid-340-40">
	<div class="main-grid-sidebar_right">
		<h2 >Доступные валютные пары</h2>
		<div class="main-padding_10 main-block_grayLight main-bordered-double">
			<table class="table-info">
				<tr>
					<td><b>BTC/USD</b></td>
					<td>курс Bitcoin к доллару</td>
				</tr>
				<tr>
					<td><b>LTC/BTC</b></td>
					<td>курс Litecoin к Bitcoin</td>
				</tr>
				<tr>
					<td><b>VTC/BTC</b></td>
					<td>курс Vertcoin к Bitcoin</td>
				</tr>
				<tr>
					<td><b>DOGE/BTC</b></td>
					<td>курс Dogecoin к Bitcoin</td>
				</tr>
				<tr>
					<td><b>PPC/BTC</b></td>
					<td>курс Peercoin к Bitcoin</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="main-grid-content_left">
		<h2>Как генерируется URL для получения данных</h2>
		<a class="main-padding_10 img-wrap-block fancybox" title="Как генерируется URL для получения данных" style="max-width:800px;" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/api_formula.jpg"><img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/api_formula.jpg"/></a>
	</div>
</section>

<hr class="hr-double hr-bigMarg"/>

<section>
<h2>Готовые примеры кода</h2>
<p>Для получения битфорк индекса криптовалют вы можете отправлять на наш сервер GET запросы. Ниже мы выложили готовые примеры запроса и ответа от нашего сервера для вашего удобства.</p>

<script type="text/javascript">
	$(document).ready(function(){
		$(window).load(function(){
			$('#sidebar1').scrollToFixed({
				marginTop: 50,
				limit: function() {
					var limit = $('#sidebar1').parents('.main-grid-340-40').offset().top + $('#sidebar1').parents('.main-grid-340-40').height() - $('#sidebar1').height();
					return limit;
				},
				zIndex: 999
			});
		});
	});
</script>

<div class="main-grid-340-40 main-margTop2">
	<div class="main-grid-sidebar_right">
		<div id="sidebar1" class="main-padding_10">
			<h3>Навигация по примерам</h3>
			<div class="main-padding_10 main-block_grayLight main-bordered-double list-links">
				<a href="#sec1">Получение моментального курса Bitcoin к доллару США</a>
				<a href="#sec2">Получение среднего за час курса Bitcoin к доллару США</a>
				<a href="#sec3">Получение среднего за сутки курса Bitcoin к доллару США</a>
				<a href="#sec4">Получение моментального курса Litecoin к Bitcoin</a>
				<a href="#sec5">Получение среднего за час курса Litecoin к Bitcoin</a>
				<a href="#sec6">Получение среднего за сутки курса Litecoin к Bitcoin</a>
				<a href="#sec7">Конструктор для других криптовалютных пар</a>
			</div>
		</div>
	</div>

	<div class="main-grid-content_left">
		<article id="sec1">
			<h3>Получение моментального курса Bitcoin к доллару США</h3>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = $this->createAbsoluteUrl("/api/".$pair_1->currency_from->name ."/". $pair_1->currency->name ."/0"); ?>
				<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
			</div>
		</article>

		<article id="sec2" class="main-margTop2">
			<h3>Получение среднего за час курса Bitcoin к доллару США</h3>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = $this->createAbsoluteUrl("/api/".$pair_1->currency_from->name ."/". $pair_1->currency->name ."/60"); ?>
				<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
			</div>
		</article>

		<article id="sec3" class="main-margTop2">
			<h3>Получение среднего за сутки курса Bitcoin к доллару США</h3>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = $this->createAbsoluteUrl("/api/".$pair_1->currency_from->name ."/". $pair_1->currency->name ."/1440"); ?>
				<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
			</div>
		</article>

		<article id="sec4" class="main-margTop2">
			<h3>Получение моментального курса Litecoin к Bitcoin</h3>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = $this->createAbsoluteUrl("/api/".$pair_2->currency_from->name ."/". $pair_2->currency->name ."/0"); ?>
				<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
			</div>
		</article>

		<article id="sec5" class="main-margTop2">
			<h3>Получение среднего за час курса Litecoin к Bitcoin</h3>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = $this->createAbsoluteUrl("/api/".$pair_2->currency_from->name ."/". $pair_2->currency->name ."/60"); ?>
				<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
			</div>
		</article>

		<article id="sec6" class="main-margTop2">
			<h3>Получение среднего за сутки курса Litecoin к Bitcoin</h3>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = $this->createAbsoluteUrl("/api/".$pair_2->currency_from->name ."/". $pair_2->currency->name ."/1440"); ?>
				<?php echo $this->renderPartial('_api_example', array('apiExampleForm'=>$apiExampleForm)); ?>
			</div>
		</article>

		<script language="javascript">
			$( document ).ready(function() {
				//$('submit').trigger('click');
			});
			function apiBeforeValidate(form) {
				$(form).find('.responseApi').val('');
				return true;
			}
			function apiAfterValidate(form, data, hasError) {
				if(!hasError) {
					$(form).find('.responseApi').val(data.content);
					return false;
				}
				return true;
			}
		</script>
	</div>
</div>

<hr class="hr-double hr-bigMarg"/>
<div class="main-grid-340-40 main-margTop2">
	<div class="main-grid-sidebar_right">
		<h2>Доступные валютные пары</h2>
		<div class="main-padding_10 main-block_grayLight main-bordered-double">
			<table class="table-info">
				<tr>
					<td><b>BTC/USD</b></td>
					<td>курс Bitcoin к доллару</td>
				</tr>
				<tr>
					<td><b>LTC/BTC</b></td>
					<td>курс Litecoin к Bitcoin</td>
				</tr>
				<tr>
					<td><b>VTC/BTC</b></td>
					<td>курс Vertcoin к Bitcoin</td>
				</tr>
				<tr>
					<td><b>DOGE/BTC</b></td>
					<td>курс Dogecoin к Bitcoin</td>
				</tr>
				<tr>
					<td><b>PPC/BTC</b></td>
					<td>курс Peercoin к Bitcoin</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="main-grid-content_left">
		<article id="sec7">
			<h2>Конструктор для других криптовалютных пар</h2>
			<div class="main-block_graySimple main-padding_10">
				<?php $apiExampleForm->api_example = ''; ?>
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'form_construct',
						'enableAjaxValidation'=>true,
						'action'=>$this->createUrl('/course/apiExample'),
						'htmlOptions' => array('enctype'=>'multipart/form-data'),
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
							'validateOnChange'=>true,
							'beforeValidate'=>'js:apiBeforeValidate',
							'afterValidate'=>'js:apiAfterValidate',
						),
					));
					$rand = rand(0,99);
				?>
				<table class="table-bordless">
					<tbody>
					<tr>
						<td><h3>Пара валют:</h3></td>
						<td>
							<select class="inp-mid" name="pair">
								<?php foreach ($pairs as $pair) { ?>
									<option value="<?php echo $pair->currency_from->name .'/'. $pair->currency->name; ?>"><?php echo $pair->currency_from->name .'/'. $pair->currency->name; ?></option>
								<?php } ?>
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td><h3>Период:</h3></td>
						<td>
							<select class="inp-mid" name="period">
								<option value="0">Моментальный курс</option>
								<option value="60">Курс за час</option>
								<option value="1440">Курс за сутки</option>
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td><h3>Get запрос:</h3></td>
						<td>
							<?php echo $form->textField($apiExampleForm,'api_example',array('class'=>'inp-mid')); ?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td><h3>Ответ в формате JSON:</h3></td>
						<td>
							<textarea class="inp-mid textarea-mid responseApi"></textarea>
						</td>
						<td>
							<a class="ico-reload" title="<?php echo Yii::t('main', 'Обновить код'); ?>" href="javascript:;" onclick="$('#form-submit-example<?php echo $rand; ?>').trigger('click');return false;"></a>
							<?php echo CHtml::submitButton('', array('id'=>'form-submit-example'.$rand, 'style'=>'display:none;')); ?>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<?php echo $form->error($apiExampleForm,'api_example'); ?>
						</td>
					</tr>
					</tbody>
				</table>
				<?php $this->endWidget(); ?>

				<script language="javascript">
					function getUrlConstruct() {
						var url = '<?php echo $this->createAbsoluteUrl("/api"); ?>';
						$("#form_construct #ApiExampleForm_api_example").val(url +'/'+ $('#form_construct select[name=pair]').val() +'/'+ $('#form_construct select[name=period]').val());
					}
					$( document ).ready(function() {
						$('select[name=pair]').change(function(){
							getUrlConstruct();
						});
						$('select[name=period]').change(function(){
							getUrlConstruct();
						});
						$('select[name=period]').trigger('change');
					});
				</script>
			</div>
		</article>
	</div>
</div>

</section>