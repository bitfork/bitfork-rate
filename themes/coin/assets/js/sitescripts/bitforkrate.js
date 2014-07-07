jQuery(document).ready(function($) {
  	
  $('input[placeholder], textarea[placeholder]').placeholderEnhanced();

  /*FANCYBOX*/

  $('.fancyboxForm').fancybox({
      minWidth   : 600,
      autoResize : true,
      arrows     : false,
      helpers: 
                {
                  overlay : {
                    closeClick : false,
                    showEarly  : true,
                    locked     : true   // if true, the content will be locked into overlay
                  },
                  title : {
                    type : 'float' // 'float', 'inside', 'outside' or 'over'
                  }
                }
  });

  $('.fancybox').fancybox({
      autoResize : true,
      arrows     : false,
      helpers: 
                {
                  overlay : {
                    closeClick : false,
                    showEarly  : true,
                    locked     : true   // if true, the content will be locked into overlay
                  },
                  title : {
                    type : 'float' // 'float', 'inside', 'outside' or 'over'
                  }
                }
  });

  /*end of FANCYBOX*/
  	
  
  $(window).load(function(){
      $('header').scrollToFixed();
  	});
	  
});