$('document').ready(function(){
	$('#application').initializeForm();
	enableTableSort();
	enableQuickSearch();
});

function enableTableSort(){
	$(".basic-table").tablesorter({widgets: ['zebra']});
}
function enableQuickSearch(){
	$('.qs-input').quicksilver($('.basic-table tbody tr'));
/*
	$('.basic-table tbody').quicksearch({
	  position: 'before',
	  attached: '.basic-table',
	  stripeRowClass: ['odd', 'even'],
	  loaderText: 'loading',
	  labelText: '',
	  delay: 100
	});
	*/
}