var WS = (function(){
	var $this;
	var ws;
	var url = 'ws://bitfork-rate.com:8002/';
	//var url = 'ws://127.0.0.1:8002/';

	return {
		init: function(){
			$this = this;
			this.start();
		},
		start: function() {
			$this.notif('connect');
			$this.console('init');
			ws = new WebSocket(url);
			ws.onopen = function() {
				$this.console('open');
				$this.notif('open');
				setTimeout($this.clearNotif, 2000);
			};
			ws.onclose = function() {
				$this.console('close');
				$this.notif('close');
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
		},
		notif: function(message) {
			if ($('#notif').length) {
				$('#notif').html(message);
			} else {
				$('body').append('<div id="notif" style="background: none repeat scroll 0 0 #0071BC;border: 1px solid #00588E;bottom: 10px;color: #FFFFFF;font-size: 12px;opacity: 0.4;padding: 0 3px;position: fixed;right: 10px;">'+message+'</div>');
			}
		},
		clearNotif: function() {
			$('#notif').remove();
		}
	}
})();