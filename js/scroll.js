// JavaScript Document

var up_timer

function getPosition(){
	yoko = document.body.scrollLeft || document.documentElement.scrollLeft;
	tate = document.body.scrollTop  || document.documentElement.scrollTop;

}

function pageup(x,y){
	if(up_timer) clearTimeout(up_timer);
	if(y >= 1){
		getPosition();
		var divisionY = (tate-(tate/5));
		var Y = Math.floor(divisionY);
		window.scrollTo(yoko,Y);
		up_timer = setTimeout("pageup("+yoko+","+Y+")",2);
	}else{
		window.scrollTo(yoko,0);
		clearTimeout(up_timer);
	}
}

function scrollup(){
		getPosition();
		pageup(yoko,tate)
}