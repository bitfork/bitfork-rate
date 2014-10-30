<h1><?php echo Yii::t('main', 'Widget'); ?></h1>

<style>
	.widget-content {
		height: 26px
	}
	.widget-date {
		font-size: 12px
	}
</style>
<div data-bitfork="BTC/USD"
	 data-css-class-content="widget-content"
	 data-css-class-index=""
	 data-css-class-date="widget-date"
	 data-loader="загрузка ..."
	></div>
<script src="/widget/widget.min.js"></script>

<br />
<textarea name="clipboard-text" id="clipboard-text" cols="60" rows="10">
<div data-bitfork="LTC/USD"
	 data-css-class-content="widget-content"
	 data-css-class-index=""
	 data-css-class-date="widget-date"
	 data-loader="загрузка ..."
></div>
<script src="http://bitfork-rate.com/widget/widget.min.js"></script>
</textarea>
<br />
<button class="btn-blue" id="target-to-copy" data-clipboard-target="clipboard-text"><?php echo Yii::t('main', 'Click To Copy'); ?></button>

<script src="/themes/coin/assets/js/zeroclipboard/dist/ZeroClipboard.js"></script>
<script language="javascript">
	var client = new ZeroClipboard( $('#target-to-copy'), {
		moviePath: "/themes/coin/assets/js/zeroclipboard/dist/ZeroClipboard.swf"
	} );
	client.on( "copy", function(e) {
		alert('готово');
	} );
</script>