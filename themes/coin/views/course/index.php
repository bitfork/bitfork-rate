<!-- BEGIN MARKET SALES WIDGET -->
<div class="row tiles-container tiles white" data-aspect-ratio="true" style="height: auto !important; min-height: 510px !important;">
	<div class="col-md-7 b-grey b-r no-padding" style="height:100%">
		<div class="p-l-20 p-r-20 p-b-10 p-t-10 b-b b-grey">
			<h5 class="text-success bold inline">Bitfork индекс</h5>
			<h5 class="text-black bold inline">- курс обмена криптовалют</h5>
			<div class="">
				<h5 class="text-black bold">Bitfork курс</h5>
				<i class="fa fa-2x <?php echo ($change[0]===RateIndex::CHANGE_DOWN) ? 'fa-sort-asc text-error' : 'fa-sort-desc text-success'; ?> inline p-b-10" style="vertical-align: super;"></i><!-- fa-sort-asc стрелка вниз, text-error красный цвет шрифта -->
				<h1 class="text-<?php echo ($change[0]===RateIndex::CHANGE_DOWN) ? 'error' : 'success'; ?> bold inline no-margin"> <?php echo ViewPrice::GetResult($index); ?></h1>
			</div>
		</div>
		<div class="p-l-20 p-r-20 p-b-10 p-t-10 b-b b-grey">
			<div class="pull-left">
				<p class="text-black">Измененеия за 24 часа</p>
				<p class="text-<?php echo ($change[0]===RateIndex::CHANGE_DOWN) ? 'error' : 'success'; ?>"><?php echo RateIndex::getStrChangeId($change[0]); ?> <?php echo $change[1]; ?>%</p>
			</div>
			<div class="pull-right">
				<p class="text-black">Диапазон торгов за 24 часа</p>
				<p class="text-success"><?php echo ViewPrice::GetResult($range['min']); ?> - <?php echo ViewPrice::GetResult($range['max']); ?></p>
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
		<div class="p-l-15 p-r-15 p-b-10 p-t-10 b-b b-grey">
			<h4 class="text-black ">Другие криптовалюты</h4>
			<select id="source" style="width:100%">
				<option value="CA">BTC / USD</option>
				<option value="NV">LTC / USD</option>
				<option value="OR">BTC / LTC</option>
			</select>
		</div>
		<div class="scroller" data-height="410px" data-always-visible="1">
			<?php foreach ($data as $row) { ?>
				<div class="p-l-15 p-r-15 p-b-10 p-t-10 b-b b-grey">
					<div class="pull-left">
						<p class="small-text"><?php echo $row['name_service']; ?></p>
					</div>
					<div class="pull-right">
						<p class="small-text">BTC</p>
					</div>
					<div class="clearfix"></div>
					<div class="pull-left">
						<i class="fa fa-sort-desc text-success inline p-b-10" style="vertical-align: middle;"></i>
						<h4 class="text-success semi-bold inline"><?php echo ViewPrice::GetResult($row['avg_price']); ?></h4>
					</div>
					<div class="pull-right" style="line-height: 27px;"> <span class="label label-success" style="vertical-align: bottom;">+3,5%</span> </div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
			<div class="p-l-15 p-r-15 p-b-10 p-t-10 b-grey">
				<button type="button" class="btn btn-default btn-block">Добавить свою биржу</button>
			</div>
		</div>
	</div>
</div>
<!-- END MARKET SALES WIDGET -->
<?php /*
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/dashboard_v2.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		alert('asd');
		$(".live-tile,.flip-list").liveTile();
	});
</script>
 */ ?>