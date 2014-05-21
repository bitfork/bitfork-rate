<section class="main-bordered-vertical main-separated-vertical main-grid-380 main-grid380_bord main-block_grayLight">
	<div class="main-grid-sidebar_right">
		<div class="main-padding_10">
			<h3><?php echo Yii::t('main', 'При подсчете курса мы используем:'); ?></h3>
			<table class="table-dotted">
				<thead>
				<tr>
					<th><?php echo Yii::t('main', 'Название биржы'); ?></th>
					<th><?php echo Yii::t('main', 'URL биржы'); ?></th>
					<th><?php echo Yii::t('main', 'Курс'); ?> <?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></th>
				</tr>
				</thead>
				<tbody>
				<?php $exchange = Yii::app()->exchange; ?>
				<tr><td colspan="3"></td></tr>
				<?php foreach ($data as $row) { ?>
					<tr>
						<td><?php echo $row['name_service']; ?></td>
						<td>
							<?php
								$exchange->setService($row['name_service']);
								echo $exchange->getBaseUrl();
							?>
						</td>
						<td id="service_price_<?php echo $row['id_service']; ?>"><?php echo ViewPrice::GetResult($row['avg_price'], Currency::getSymbol($index['id_currency']), Currency::getCountRound($index['id_currency'])); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<a class="btn-blue btn-block" href="#"><?php echo Yii::t('main', 'Добавить другую биржу'); ?></a>
		</div>
	</div>

	<div class="main-grid-content_left">
		<div class="main-padding_10">
			<div class="main-grid-300">
				<div class="main-grid-sidebar_left"><p class="main-bordered-double text-font_mid text-center"><?php echo ViewPrice::GetResult($index['index'], Currency::getSymbol($index['id_currency']), Currency::getCountRound($index['id_currency'])); ?></p></div>
				<div class="main-grid-content_right">
					<h3><?php echo Yii::t('main', 'Моментальный курс {cur_from}/{cur}', array('{cur_from}'=>$pair->currency_from->name,'{cur}'=>$pair->currency->name)); ?></h3>
					<p><?php echo Yii::t('main', 'Последнее обновление'); ?> <span id="last_date_main_index"><?php echo date('D, d.m.y\, H:i', strtotime($index['create_date'])); ?></span> GMT+0400<br/>
						<span class="text-tip"><?php echo Yii::t('main', 'Информация обновляется каждые 5 - 10 секунд'); ?></span>
					</p>
				</div>
			</div>

			<div id="index-graph_title" class="main-grid-300">
				<p class="text-font_mid main-grid-sidebar_left line-arrowBack"><span><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></span></p>
				<div class="main-grid-content_right">
					<h3><?php echo Yii::t('main', 'График изменения за 24 часа'); ?></h3>
					<?php echo $this->renderPartial('_chart', array('id'=>$pair->id)); ?>
				</div>
			</div>
		</div>
	</div>
</section>