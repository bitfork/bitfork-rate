var BitforkRateWidget = (function () {
	var obj = {},
		wrapper,
		currency_base = 'BTC',
		currency_target = 'USD',
		data_rate,
		old_data_rate,
		timer,
		css_class_content,
		css_class_index,
		css_class_date,
		loader = 'загрузка';

	obj.init = function ()
	{
		wrapper = $('[data-bitfork]');
		if (typeof wrapper == "undefined" || wrapper.length<=0) {
			return false;
		}
		var pair = wrapper.data('bitfork');
		pair = pair.split('/');
		currency_base = pair[0];
		currency_target = pair[1];
		if (typeof wrapper.attr('class') == "undefined" || wrapper.attr('class')=='') {
			var css = '<style>.widget-bitfork-rate {background-color: #eee;border: 1px solid #1966ff;width: 200px;padding: 15px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;-webkit-box-shadow: 0px 0px 7px 0px rgba(50, 50, 50, 0.75);-moz-box-shadow: 0px 0px 7px 0px rgba(50, 50, 50, 0.75);box-shadow: 0px 0px 7px 0px rgba(50, 50, 50, 0.75);}</style>';
			wrapper.before(css);
			wrapper.addClass('widget-bitfork-rate');
		}
		css_class_content = wrapper.data('css-class-content');
		if (typeof css_class_content != "undefined") {
			css_class_content = ' class="'+ css_class_content +'"';
		}
		css_class_index = wrapper.data('css-class-index');
		if (typeof css_class_index != "undefined") {
			css_class_index = ' class="'+ css_class_index +'"';
		}
		css_class_date = wrapper.data('css-class-date');
		if (typeof css_class_date != "undefined") {
			css_class_date = ' class="'+ css_class_date +'"';
		}
		var set_loader = wrapper.data('loader');
		if (typeof set_loader != "undefined" && set_loader != '') {
			loader = set_loader;
		}
		wrapper.html('<div id="bitfork-rate-content"'+ css_class_content +'></div><div style="font-size: 10px;text-align: right;">Powered by<br /><a href="http://bitfork-rate.com" target="_blank">bitfork-rate.com</a></div>');
		wrapper = $('#bitfork-rate-content');
		show();
	};

	function show()
	{
		getData();
		timer = setInterval( function(){
			getData();
		}, 10000);
	}
	function clearTimer()
	{
		clearInterval(timer);
	}
	function getData()
	{
		$.ajax({
			url: 'http://bitfork-rate.com/api/'+ currency_base +'/'+ currency_target +'/0',
			dataType: 'json',
			beforeSend: function() {
				showLoader();
			},
			success: function(json) {
				data_rate = json;
				showData();
			}
		});
	}
	function showData()
	{
		if (data_rate.success) {
			var rate = parseFloat(data_rate.data.index);
			wrapper.html('<span'+ css_class_index +'>1 '+ currency_base +' = <b>'+ rate.toFixed(2) +'</b> '+ currency_target +'</span><br /><span'+ css_class_date +'>'+ data_rate.data.date +'</span>');
		} else {
			wrapper.html(old_data_rate);
		}
	}
	function showLoader()
	{
		old_data_rate = wrapper.html();
		wrapper.html(loader);
	}

	return obj;
}());
$( document ).ready(function() {
BitforkRateWidget.init();
});