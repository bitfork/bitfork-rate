<h1><?php echo Yii::t('main', 'Анализатор лучших цен покупки Bitcoin, Litecoin, Darkcoin на популярных биржах.'); ?></h1>

<p><?php echo Yii::t('main', 'Данный сервис запущен осенью 2014 года. Введите интересующую сумму покупки криптовалюты, укажите валюту за которую вы хотите приоб-рести и нажмите кнопку «Анализировать». Наш сервис опросит подключенные биржи и покажет наиболее выгодное актуальное предложение.'); ?></p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'top-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('class'=>'main-bordered-vertical main-separated-vertical'),
)); ?>

	<table class="table-bordless table-align-m">
		<tbody>
		<tr>
			<td><?php echo Yii::t('main', 'Укажите сумму покупки:'); ?></td>
			<td><?php echo $form->textField($model,'volume'); ?></td>
			<td><?php echo $form->dropDownList($model,'id_service_1', CHtml::listData(Currency::model()->findAll(), 'id', 'name')); ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('main', 'Укажите валюту, за которую хотите купить:'); ?></td>
			<td><?php echo $form->dropDownList($model,'id_service_2', CHtml::listData(Currency::model()->findAll(), 'id', 'name')); ?></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php echo $form->errorSummary($model); ?>
				<?php echo CHtml::submitButton(Yii::t('main', 'Анализировать')); ?>
			</td>
			<td></td>
		</tr>
		</tbody>
	</table>

	<div style="display: none">
		<?php echo $form->error($model,'volume'); ?>
		<?php echo $form->error($model,'id_service_1'); ?>
		<?php echo $form->error($model,'id_service_2'); ?>
		<?php echo $form->error($model,'is_buy'); ?>
	</div>

	<?php if (!empty($result)) { ?>
		<div id="bestprice-result">
			<hr/>
			<h2><?php echo Yii::t('main', 'Результат анализа цен.'); ?></h2>
			<blockquote>
				<?php echo Yii::t('main', 'Лучше всего {is_buy} на <a href="http://{service}" target="_blank">{service}</a>.<br/> Общая сумма лотов: <i>{summa}</i> за <i>{price}</i>. <br/>Курс составит <b>~ {course}</b>.',
					array(
						'{is_buy}'=>(($model->is_buy == 1) ? Yii::t('main', 'купить') : Yii::t('main', 'продать')),
						'{service}'=>$result[1][$result[0]]['service_url'],
						'{summa}'=>ViewPrice::GetResult($result[1][$result[0]]['data']['volume'], $currency_1->symbol, $currency_1->round),
						'{price}'=>ViewPrice::GetResult($result[1][$result[0]]['data']['summa'], $currency_2->symbol, $currency_2->round),
						'{course}'=>ViewPrice::GetResult(($result[1][$result[0]]['data']['summa'] / $result[1][$result[0]]['data']['volume']), $currency_2->symbol, $currency_2->round) .'/'. $currency_1->symbol,
					)); ?>
			</blockquote>

			<table class="table-dotted table-hover-tr">
				<thead>
				<tr>
					<td><?php echo Yii::t('main', 'Размер лота'); ?></td>
					<td><?php echo Yii::t('main', 'Стоимость лота'); ?></td>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($result[1][$result[0]]['data']['list'] as $item) { ?>
					<tr>
						<td><?php echo ViewPrice::GetResult($item[1], $currency_1->symbol, $currency_1->round); ?></td>
						<td><?php echo ViewPrice::GetResult(($item[0] * $item[1]), $currency_2->symbol, $currency_2->round); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>

<?php $this->endWidget(); ?>