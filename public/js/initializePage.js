$('document').ready(function(){
	initializePage();
});
function initializePage(){

	$('#application').enable_DateField()
	$('#application').enable_TableSort()
	$('#application').enable_QuickSearch()
	$('#application').enable_Swappable()
	$('#application').enable_Hideable()
	$('#application').enable_Ajax()

}
$.fn.slideFadeIn = function(speed, easing, callback) {
		return this.animate({opacity: 'show', height: 'show'}, speed, easing, callback);  
}

$.fn.slideFadeOut = function(speed, easing, callback) {        	
		return this.animate({opacity: 'hide', height: 'hide'}, speed, easing, callback);  
}

$.fn.enable_DateField= function(){
	$(this).find(".date-field").datepicker({ dateFormat: 'yy-mm-dd'});
  return this;
}

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

$.fn.enable_MultiSelect = function(){
	$('.multiselect').multiSelect({oneOrMoreSelected: '*'});
}

$.fn.enable_Ajax = function(){
	initializeSubmitButtons();
	function initializeSubmitButtons(){
		$('.standard-form').submit( function(){
			form = this;
			getGraphData();
			return false;
		});
	}
    function getGraphData(){
		showLoaderGraphic();
		$.ajax({
			type: 'GET',
			url: 'index.php',
			data: serializeFormData(),
			success: function(JSONtext){
				loadView(JSONtext);
				initializeSubmitButtons();
				initializePage();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  hideLoaderGraphic();
			  log('ajax request failed');
			}
		});
    }
    function log( msg){
        $('#log').append('<li>'+msg+'</li>');
        if ( console ) console.log(msg);
    }
    function loadView( html ){
        $('#hour-search-1').html( html );
        hideLoaderGraphic();
    }
    function serializeFormData() {
        var sel, serializedData = "";
        if (!form) return false;
		$( ':input', form).each(function(){
			serializedData += $(this).attr('name') + "=" + $(this).val() + "&";
		});
        selectBoxes = form.getElementsByTagName("select");
        if( selectBoxes) {
            total = selectBoxes.length;
        } else {
            total = 0;
        }
        for ( i=0; i<total; i++) {
            sel = selectBoxes[i];
            serializedData += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
        }
        return encodeURI( serializedData);
    }
    function showLoaderGraphic() {
        $('.loader').html('<div style="margin: 25% 44%">'+
            '<div style="text-align:center; width:50px"><img src="/img/ajax-loader.gif" /></div>'+
            '<div style="color:#993333; text-align:center; width:50px; font-weight:bold">Loading</div>'+
            '</div>');
    }
    function hideLoaderGraphic() {
        $(' .loader').html('');
    }
    function url( param) {
        var regex = '[?&]' + param + '=([^&#]*)';
        var results = (new RegExp(regex)).exec(window.location.href);
        if(results) return results[1].replace('%20',' ');
        return false;
    }
    function describeObject(obj) {
        str='';
        for(prop in obj){
            str+=prop + " value :"+ obj[prop]+"<br>";
        }
        return(str);
    }
}
