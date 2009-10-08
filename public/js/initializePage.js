$('document').ready(function(){
	$('#application').initializeForm();
	enableTableSort();
	enableQuickSearch();
});

function enableTableSort(){
	$(".basic-table").tablesorter({widgets: ['zebra']});
}
function enableQuickSearch(){
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