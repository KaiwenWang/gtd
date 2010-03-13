$.fn.describeObject = function( obj ){
	str='';
	for(prop in obj){
		str+=prop + " value :"+ obj[prop]+"<br>";
	}
	return(str);
}
