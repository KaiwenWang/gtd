(function($) {

 	$.fn.initializeForm = function(){
		$(this).find(".date-field").datepicker({ dateFormat: 'yy-mm-dd'});
	  return this;
	};
	$.fn.submitForm = function(){};
	
})(jQuery);