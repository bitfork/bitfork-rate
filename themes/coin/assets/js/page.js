var Page = (function(){
	var pair;
	var chart;

	return {
		init: function(pair, chart){
			this.pair = pair;
			this.chart = chart;
			this.chart.update(0, 0);
		},
		update: function(data) {
			if (this.pair == data.pair) {
				$('#main_index').html(data.index);
				$('#last_date_main_index').html(data.date);
				for (var key in data.services) {
					if (data.services.hasOwnProperty(key)) {
						$('#service_price_'+ data.services[key].id +'').html(data.services[key].price);
					}
				}
				if (this.chart != '') {
					this.chart.update(data.index_num, data.timestamp, data.index);
				}
			}
		}
	}
})();