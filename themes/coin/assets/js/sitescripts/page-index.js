jQuery(document).ready(function($) {
	
	/*INTERVAL FOR VOLUME*/
	var timer = null;

	function startSetInterval() {
	    var volume_measure_html;

	    timer = setInterval( function(){
	    	$('#volume_measure').fadeOut('slow', function(){
		    	var $this = $(this);

		    	if ( $this.html() == 'BTC' )
		    		volume_measure_html = '%';
		    	else
		    		volume_measure_html = 'BTC';

		    	$this
	    		.html(volume_measure_html)
	    		.fadeIn('slow');
	    	});


	    	$('.volume_shift').fadeOut('slow', function(){
	    		var $this = $(this);
	    		var $vol = $this.children('span');
	    		var class_shift = 'shifted';

	    		if ( $vol.hasClass(class_shift) )
		    		$vol.removeClass(class_shift);
		    	else
		    		$vol.addClass(class_shift);

	    		$this.fadeIn('slow');
	    	});
	    }, 5000);
	}

	// start function on page load
	startSetInterval();

	// hover behaviour
	$('.volume_col').hover(function() {
	  clearInterval(timer);
	},function() {
	  startSetInterval();
	});

	/*END INTERVAL FOR VOLUME*/

	/*TOGGLE EXCHANGES*/
	$('#js-index-exchanges-toogle').on('click', function(e){
		e.preventDefault();
		var $this = $(this);
		var $tr_toggle = $('tr.hide-row');

		if ( $tr_toggle.is(':hidden') ) {
			$tr_toggle.fadeIn('slow', function(){
				$this.html('Hide');
			});
		}
		else
		{
			$tr_toggle.fadeOut('slow', function(){
				$this.html('Show more');
			});
		}
	});
	/*END TOGGLE EXCHANGES*/

});