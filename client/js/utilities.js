util = {

	describeObject : function( obj ){
		str='';
		for(prop in obj){
			str+=prop + " value :"+ obj[prop]+"<br>";
		}
		return(str);
	},

	log : function ( msg){
		$('#log').append('<li>'+msg+'</li>');
		if ( console ) console.log(msg);
	}

}
