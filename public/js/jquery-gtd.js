(function($) {
    $.fn.slideFadeIn = function(speed, easing, callback) {
        	return this.animate({opacity: 'show', height: 'show'}, speed, easing, callback);  
    };
    $.fn.slideFadeOut = function(speed, easing, callback) {        	
        	return this.animate({opacity: 'hide', height: 'hide'}, speed, easing, callback);  
	};
 	$.fn.initializeForm = function(){
		$(this).find(".date-field").datepicker({ dateFormat: 'yy-mm-dd'});
	  return this;
	};
	$.fn.submitForm = function(){};

	$.fn.enable_TableSort = function (){
		$(".basic-table").tablesorter({widgets: ['zebra']});
	}
	$.fn.enable_QuickSearch = function (){
		$('.basic-table-container').each( function() {
			rows = $(this)
					.children('.basic-table')
					.children('tbody')
					.children('tr');
			selector = 	$(this)
						.children('.quicksearch')
						.children('form')
						.children('.qs-input');
			selector.quicksearch(rows);
		});
	}
	$.fn.enable_Swappable = function (){
		$(".js-swappable-btn").each( function(){
			$(this).click( function(){
				$(this).siblings('.swappable-item').toggle();
			})
		});
	}
	$.fn.enable_Hideable = function (){
		$(".js-hideable-btn").each( function(){

			$(this).click( function(){
				item = $(this).siblings('.hideable-item');
				if ( item.css('display') == 'none' ){
					item.slideFadeIn(180,'easeOutCubic');
				} else {
					item.slideFadeOut(180,'easeInCubic');
				}
			})
		});
	}
	
})(jQuery);