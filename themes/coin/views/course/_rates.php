<section class="main-bordered-vertical main-separated-vertical main-grid-400 main-grid400_bord main-block_grayLight">
	<div class="main-grid-sidebar_right">
		<div class="main-padding_10">
			<h3><?php echo Yii::t('main', 'При подсчете курса мы используем:'); ?></h3>
			<div class="main-overflow-x">
				<table id="js-init_changeObj" class="table-dotted table-hover-tr table-fullWidth">
					<thead>
					<tr>
						<th><?php echo Yii::t('main', 'URL биржы'); ?></th>
						<th>
							<?php echo Yii::t('main', 'Курс'); ?>
							<p class="text-small text-nowrap">
								<?php
								if (!empty($pair->id_currency_intermed)) {
									echo $pair->currency_from->name .' / '. $pair->currency_intermed->name;
								} else {
									echo $pair->currency_from->name .' / '. $pair->currency->name;
								}
								?>
							</p>
						</th>
						<th class="volume_col"><?php echo Yii::t('main', 'Volume'); ?> <p id="volume_measure" class="text-small text-nowrap">%</p></th>
						<?php /*<th>
							<?php echo Yii::t('main', 'Курс'); ?> 
							<p class="text-small text-nowrap"><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></p>
						</th>*/ ?>
					</tr>
					</thead>
					<tbody>
					<?php $exchange = Yii::app()->exchange; ?>
					<tr class="tr-nohover"><td colspan="4"></td></tr>
					<?php
					function myCmp($a, $b) {
						if ($a['percent_for_index'] === $b['percent_for_index']) return 0;
						return $a['percent_for_index'] < $b['percent_for_index'] ? 1 : -1;
					}
					uasort($data, 'myCmp');
					$i = 1;
					$c = 6;
					?>
					<?php foreach ($data as $row) { ?>
						<?php if ($i<=$c) { ?>
						<tr>
						<?php } else {?>
						<tr style="display: none" class="hide-row">
						<?php } ?>
							<td>
								<?php
								$exchange->setService($row['name_service']);
								echo $exchange->getBaseUrl();
								?>
							</td>
							<td id="service_price_in_<?php echo $row['id_service']; ?>">
								<span class="text-nowrap">
									<?php
									if (!empty($pair->id_currency_intermed)) {
										echo ($row['price_intermed_2']>0) ? ViewPrice::GetResult($row['price_intermed_2'], $pair->currency_intermed->symbol, $pair->currency_intermed->round) : 'loss';
									} else {
										echo ($row['avg_price']>0) ? ViewPrice::GetResult($row['avg_price'], $pair->currency->symbol, $pair->currency->round) : 'loss';
									}
									?>
								</span>
							</td>
							<td id="service_volume_<?php echo $row['id_service']; ?>" class="volume_col">
								<aside class="volume_shift">
									<span class="volume_shift_1 text-nowrap">
										<?php
										$percent = (float)$row['percent_for_index'] * 100;
										echo ($percent>0) ? (($percent >= 0.1) ? round($percent, 2) .'%' : '&lt; 0.1 %') : 'loss';
										?>
									</span>
									<span class="volume_shift_2 text-nowrap">
										<?php echo ViewPrice::GetResult($row['avg_volume'], ' ', 2); ?>
									</span>
								</aside>
							</td>
							<?php /*<td id="service_price_<?php echo $row['id_service']; ?>">
								<span class="text-nowrap">
									<?php echo ($row['avg_price']>0) ? ViewPrice::GetResult($row['avg_price'], $pair->currency->symbol, $pair->currency->round) : 'loss'; ?>
								</span>
							</td>*/ ?>
						</tr>
						<?php $i++; ?>
					<?php } ?>
					<?php if (count($data)>$c) { ?>
					<tr class="tr-nohover">
						<td colspan="4">
							<p class="text-center m-t-5 m-b-5">
								<a id="js-index-exchanges-toogle" href="javascript:;" class="text-a-dotted">
									<?php echo Yii::t('main', 'Show more'); ?>
								</a>
							</p>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php
				$js = "$('#js-init_changeObj').changeVolume({currency: '". $pair->currency_from->symbol ."'});";
				Yii::app()->clientScript->registerScript('currency',$js);
				?>
			</div>
			<a class="btn-blue btn-block fancybox fancybox.ajax" href="<?php echo $this->createUrl('/course/linkExchange'); ?>"><?php echo Yii::t('main', 'Добавить другую биржу'); ?></a>
		</div>
	</div>

	<div class="main-grid-content_left">
		<div class="main-padding_10">
			<div class="main-grid-340">
				<div class="main-grid-sidebar_left">
					<p class="main-bordered-double text-font_mid text-center">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/loader.gif" alt="Updating..." id="loader-index" style="display: none;left: 20px;position: absolute;top: 38px;">
						<span id="main_index">
							<?php echo ViewPrice::GetResult($index['index'], Currency::getSymbol($index['id_currency']), Currency::getCountRound($index['id_currency'])); ?>
						</span>
					</p>
				</div>
				<div class="main-grid-content_right">
					<h3><?php echo Yii::t('main', 'Моментальный курс {cur_from}/{cur}', array('{cur_from}'=>$pair->currency_from->name,'{cur}'=>$pair->currency->name)); ?></h3>
					<p><?php echo Yii::t('main', 'Последнее обновление'); ?> <span id="last_date_main_index"><?php echo date('D\, d.m.y\, H:i:s', strtotime($index['create_date'])); ?></span> UTC<br/>
						<span class="text-tip"><?php echo Yii::t('main', 'Информация обновляется каждые 5 - 10 секунд'); ?></span>
					</p>
				</div>
			</div>

			<div id="index-graph_title" class="main-grid-340">
				<p class="text-font_mid main-grid-sidebar_left line-arrowBack"><span><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></span></p>
				<div class="main-grid-content_right">
					<h3><?php echo Yii::t('main', 'График изменения за 24 часа'); ?></h3>
				</div>
			</div>
			<?php echo $this->renderPartial('_chart', array('id'=>$pair->id)); ?>
		</div>
	</div>
</section>