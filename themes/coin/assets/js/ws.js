var WS = (function(){
	var $this;
	var ws;
	//var url = 'ws://prometheus-seo.ru:8002/';
	var url = 'ws://127.0.0.1:8002/';

	return {
		init: function(){
			$this = this;
			this.start();
		},
		start: function() {
			$this.console('init');
			ws = new WebSocket(url);
			ws.onopen = function() {
				$this.console('open');
			};
			ws.onclose = function() {
				$this.console('close');
				setTimeout($this.start, 1000);
			};
			ws.onmessage = function(evt) {
				var pack = JSON.parse(evt.data);
				if (pack.cmd == 'data') {
					Page.update(pack.data);
				}
				/*$this.console(pack);*/
			};
		},
		console: function(data) {
			console.log(data);
		}
	}
})();