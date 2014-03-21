<!-- BEGIN MARKET SALES WIDGET -->
<div class="row tiles-container tiles white" data-aspect-ratio="true" style="height: auto !important; min-height: 510px !important;">
	<div class="col-md-7 b-grey b-r no-padding" style="height:100%">
		<div class="p-l-20 p-r-20 p-b-10 p-t-10 b-b b-grey">
			<div class="">
				<h5 class="text-black bold"><?php echo Yii::t('main', 'Bitfork rate'); ?></h5>
				<i class="fa fa-2x <?php echo ($index['change_state']===RateIndex::CHANGE_DOWN) ? 'fa-sort-asc text-error' : 'fa-sort-desc text-success'; ?> inline p-b-10" style="vertical-align: super;"></i><!-- fa-sort-asc стрелка вниз, text-error красный цвет шрифта -->
				<h1 class="text-<?php echo ($index['change_state']===RateIndex::CHANGE_DOWN) ? 'error' : 'success'; ?> bold inline no-margin"> <?php echo ViewPrice::GetResult($index['index'], Currency::getSymbol($index['id_currency'])); ?></h1>
			</div>
		</div>
		<div class="p-l-20 p-r-20 p-b-10 p-t-10 b-b b-grey">
			<div class="pull-left">
				<p class="text-black"><?php echo Yii::t('main', '24 hour rate change'); ?></p>
				<p class="text-<?php echo ($index['change_state']===RateIndex::CHANGE_DOWN) ? 'error' : 'success'; ?>"><?php echo RateIndex::getStrChangeId($index['change_state']); ?> <?php echo $index['change_percent']; ?>%</p>
			</div>
			<div class="pull-right">
				<p class="text-black"><?php echo Yii::t('main', 'The range of trades for 24 hours'); ?></p>
				<p class="text-<?php echo ($index['change_state']===RateIndex::CHANGE_DOWN) ? 'error' : 'success'; ?>"><?php echo ViewPrice::GetResult($range['min'], Currency::getSymbol($index['id_currency'])); ?> - <?php echo ViewPrice::GetResult($range['max'], Currency::getSymbol($index['id_currency'])); ?></p>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="overlayer bottom-left fullwidth">
			<div class="overlayer-wrapper">
				<div class="" id="shares-chart-01" style="width:100%"> </div>
			</div>
		</div>
	</div>
	<div class="col-md-5 no-padding">
		<div class="scroller" data-height="410px" data-always-visible="1">
			<?php foreach ($data as $row) { ?>
				<?php $state = ($row['change_state']===RateIndex::CHANGE_DOWN) ? 'error' : 'success'; ?>
				<?php $state_label = ($row['change_state']===RateIndex::CHANGE_DOWN) ? 'important' : 'success'; ?>
				<div class="p-l-15 p-r-15 p-b-10 p-t-10 b-b b-grey">
					<div class="pull-left">
						<p class="small-text"><?php echo $row['name_service']; ?></p>
					</div>
					<div class="pull-right">
						<p class="small-text">BTC</p>
					</div>
					<div class="clearfix"></div>
					<div class="pull-left">
						<i class="fa <?php echo ($row['change_state']===RateIndex::CHANGE_DOWN) ? 'fa-sort-asc text-error' : 'fa-sort-desc text-success'; ?> inline p-b-10" style="vertical-align: middle;"></i>
						<h4 class="text-<?php echo $state; ?> semi-bold inline"><?php echo ViewPrice::GetResult($row['avg_price'], Currency::getSymbol($index['id_currency'])); ?></h4>
					</div>
					<div class="pull-right" style="line-height: 27px;"> <span class="label label-<?php echo $state_label; ?>" style="vertical-align: bottom;"><?php echo RateIndex::getStrChangeId($row['change_state']); ?> <?php echo $row['change_percent']; ?>%</span> </div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
			<div class="p-l-15 p-r-15 p-b-10 p-t-10 b-grey">
				<a class="btn btn-default btn-block" data-toggle="modal" data-target="#myModal"><?php echo Yii::t('main', 'Add your Exchange'); ?></a>
			</div>
		</div>
	</div>
</div>
<!-- END MARKET SALES WIDGET -->

<div id="myModal" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo Yii::t('main', 'Add your Exchange'); ?></h4>
			</div>
			<div class="modal-body overflow-hidden text-centr">
				<div class="inline" style="width:90%">
					<div class="input-group transparent overflow-hidden" style="width:100%">
						<div class="new-market-field">
							<span><?php echo Yii::t('main', 'Name of Exchange'); ?></span>
							<div class="inline pull-right">
								<input type="text" class="form-control" placeholder="">
							</div>
						</div>
						<div class="new-market-field">
							<span><?php echo Yii::t('main', 'Link API'); ?></span>
							<div class="inline pull-right">
								<input type="text" class="form-control" placeholder="">
							</div>
						</div>
						<div class="new-market-field">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary"><?php echo Yii::t('main', 'Submit'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php /*
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/dashboard_v2.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		alert('asd');
		$(".live-tile,.flip-list").liveTile();
	});
</script>
 */ ?>