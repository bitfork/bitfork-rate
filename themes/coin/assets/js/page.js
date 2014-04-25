var Page = (function(){
	var pair;

	return {
		init: function(pair){
			this.pair = pair;
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
			}
		}
	}
})();