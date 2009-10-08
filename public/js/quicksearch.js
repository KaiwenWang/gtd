jQuery.fn.quicksearch = function(list){
  list = jQuery(list);

  if ( list.length ) {
    var rows = list.children(),
      cache = rows.map(function(){
        return this.innerHTML.toLowerCase();
      });
     
    this
      .keyup(filter).keyup()
      .parents('form').submit(function(){
        return false;
      });
  }
   
  return this;
   
  function filter(){
    var term = jQuery.trim( jQuery(this).val().toLowerCase() );
    var scores = [];
   
    if ( !term ) {
      rows.show();
    } else {
      rows.hide();

      cache.each(function(i){ // cache is all the rows of the table
      	console.log("score = "+score);
      	console.log("i = "+i);
      	console.log("term = "+term);
        var score = scores[term];
        if (score > 0) { scores.push([score, i]); }
      });

      jQuery.each(scores.sort(function(a, b){return b[0] - a[0];}), function(){
        jQuery(rows[ this[1] ]).show();
      });
    }
  }
};