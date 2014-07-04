var Page = (function(){
	var $this;
	var pair;
	var chart;

	var html_nowrap1 = '<p class="text-nowrap">';
	var html_nowrap2 = '</p>';

	return {
		init: function(pair, chart){
			$this = this;
			this.pair = pair;
			this.chart = chart;
			this.chart.update(0, 0);
		},
		update: function(data) {
			if (this.pair == data.pair) {
				$('#loader-index').show();
				setTimeout( function(){$this.up(data);} , 1000);
			}
		},
		up: function(data) {
			$('#main_index').html(data.index);
			$('#loader-index').hide();
			$('#last_date_main_index').html(data.date);
			for (var key in data.services) {
				if (data.services.hasOwnProperty(key)) {
					$('#service_price_in_'+ data.services[key].id +'').html(html_nowrap1 + data.services[key].price_intermed + html_nowrap2);
					$('#service_price_'+ data.services[key].id +'').html(html_nowrap1 + data.services[key].price + html_nowrap2);
					$('#service_volume_'+ data.services[key].id +'').html(data.services[key].volume);
				}
			}
			if (this.chart != '') {
				this.chart.update(data.index_num, data.timestamp, data.index);
			}
		}
	}
})();