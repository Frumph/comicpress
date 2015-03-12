/**
 * instant.js 2.4 (10-Aug-2010)
 * (c) by Christian Effenberger
 * All Rights Reserved
 * Source: instant.netzgesta.de
 * Distributed under Netzgestade Software License Agreement
 * http://www.netzgesta.de/cvi/LICENSE.txt
 * License permits free of charge
 * use on non-commercial and
 * private web sites only
 */

var tmp = navigator.appName === 'Microsoft Internet Explorer' && navigator.userAgent.indexOf('Opera') < 1 ? 1 : 0;
if (tmp) var isIE = document.namespaces && (!document.documentMode || document.documentMode < 9) ? 1 : 0;

    if (isIE) {
        if (document.namespaces['v'] === null) {
            var e = ["shape", "shapetype", "group", "background", "path", "formulas", "handles", "fill", "stroke", "shadow", "textbox", "textpath", "imagedata", "line", "polyline", "curve", "roundrect", "oval", "rect", "arc", "image"], s = document.createStyleSheet();
            for (var i=0; i<e.length; i++) {s.addRule("v\\:"+e[i],"behavior: url(#default#VML);");} document.namespaces.add("v","urn:schemas-microsoft-com:vml");
	} 
}

function getImages(className){
	var children = document.getElementsByTagName('img'); 
	var elements = new Array(); var i = 0;
	var child; var classNames; var j = 0;
	for (i=0;i<children.length;i++) {
		child = children[i];
		classNames = child.className.split(' ');
		for (var j = 0; j < classNames.length; j++) {
			if (classNames[j] == className) {
				elements.push(child);
				break;
			}
		}
	}
	return elements;
}
function getClasses(classes,string){
	var temp = '';
	for (var j=0;j<classes.length;j++) {
		if (classes[j] != string) {
			if (temp) {
				temp += ' ';
			}
			temp += classes[j];
		}
	}
	return temp;
}
function getClassValue(classes,string){
	var temp = 0; var pos = string.length;
	for (var j=0;j<classes.length;j++) {
		if (classes[j].indexOf(string) === 0) {
			temp = Math.min(classes[j].substring(pos),100);
			break;
		}
	}
	return Math.max(0,temp);
}
function getClassColor(classes,string){
	var temp = 0; var str = ''; var pos = string.length;
	for (var j=0;j<classes.length;j++) {
		if (classes[j].indexOf(string) === 0) {
			temp = classes[j].substring(pos);
			str = '#' + temp.toLowerCase();
			break;
		}
	}
	if(str.match(/^#[0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f]$/i)) {
		return str;
	}else {
		return 0;
	}
}
function getClassAttribute(classes,string){
	var temp = 0; var pos = string.length;
	for (var j=0;j<classes.length;j++) {
		if (classes[j].indexOf(string) === 0) {
			temp = 1; 
			break;
		}
	}
	return temp;
}
function addShading(ctx,x,y,width,height,opacity) {
	var style = ctx.createLinearGradient(0,y,0,y+height);
	style.addColorStop(0,'rgba(0,0,0,'+(opacity/2)+')');
	style.addColorStop(0.3,'rgba(0,0,0,0)');
	style.addColorStop(0.7,'rgba(254,254,254,0)');
	style.addColorStop(1,'rgba(254,254,254,'+(opacity)+')');
	ctx.beginPath(); ctx.rect(x,y,width,height);
	ctx.closePath(); ctx.fillStyle = style; ctx.fill();
}
function addLining(ctx,x,y,width,height,opacity,inset,inner,color) {
	var style = ctx.createLinearGradient(x,y,width,height);
	if(inner===true) {
		style.addColorStop(0,'rgba(192,192,192,'+opacity+')');
		style.addColorStop(0.7,'rgba(254,254,254,0.8)');
		style.addColorStop(1,'rgba(254,254,254,0.9)');
	}else {
		if(color=='#f0f4ff') {
			style.addColorStop(0,'rgba(254,254,254,0.9)');
			style.addColorStop(0.3,'rgba(254,254,254,0.8)');
			style.addColorStop(1,'rgba(192,192,192,0)');
		}else {
			style.addColorStop(0,'rgba(254,254,254,0)');
			style.addColorStop(1,'rgba(192,192,192,0)');
		}
	}
	ctx.strokeStyle = style; ctx.lineWidth = inset;
	ctx.beginPath(); ctx.rect(x,y,width,height);
	ctx.closePath(); ctx.stroke();
}
function addRadialStyle(ctx,x1,y1,r1,x2,y2,r2,opacity) {
	var tmp = ctx.createRadialGradient(x1,y1,r1,x2,y2,r2);
	var opt = Math.min(parseFloat(opacity+0.1),1.0);
	tmp.addColorStop(0,'rgba(0,0,0,'+opt+')');
	tmp.addColorStop(0.25,'rgba(0,0,0,'+opacity+')');
	tmp.addColorStop(1,'rgba(0,0,0,0)');
	return tmp;
}
function addLinearStyle(ctx,x,y,w,h,opacity) {
	var tmp = ctx.createLinearGradient(x,y,w,h);
	var opt = Math.min(parseFloat(opacity+0.1),1.0);
	tmp.addColorStop(0,'rgba(0,0,0,'+opt+')');
	tmp.addColorStop(0.25,'rgba(0,0,0,'+opacity+')');
	tmp.addColorStop(1,'rgba(0,0,0,0)');
	return tmp;
}
function tiltShadow(ctx,x,y,width,height,radius,opacity,round){
	var style, f=round?2.5:1.25, t=round?3.5:2.25; ctx.fillStyle="rgba(0,0,0,"+(opacity*1.2)+")";
	ctx.beginPath(); ctx.rect(x+radius,y+height-y-y,width-(radius*t),y); ctx.closePath(); ctx.fill();
	ctx.beginPath(); ctx.rect(x+width-x-x,y,radius,radius); ctx.closePath(); 
	style=addLinearStyle(ctx,x+width-x-x,y+radius,x+width-x-x,y,opacity); ctx.fillStyle=style; ctx.fill();	
	ctx.beginPath(); ctx.rect(x,y+height-y-y,radius,radius); ctx.closePath(); 
	style=addLinearStyle(ctx,x+radius,y+height-y-y,x,y+height-y-y,opacity); ctx.fillStyle=style; ctx.fill();	
	ctx.beginPath(); ctx.moveTo(x+width-x-x,y+radius); ctx.lineTo(x+width-x,y+radius); ctx.quadraticCurveTo(x+width-x-x,y+(height/2),x+width-x,y+height-(radius*f)); ctx.lineTo(x+width-x-x,y+height-(radius*f)); ctx.quadraticCurveTo(x+width-(x*3),y+(height/2),x+width-x-x,y+radius); ctx.closePath(); ctx.fill();
	ctx.beginPath(); ctx.rect(x,y+height-radius,radius,radius); ctx.closePath();
	style=addRadialStyle(ctx,x+radius,y+height-radius,radius-x,x+radius,y+height-radius,radius,opacity);
	ctx.fillStyle=style; ctx.fill();
	ctx.beginPath(); ctx.rect(x+radius,y+height-y,width-(radius*t),y); ctx.closePath();
	style=addLinearStyle(ctx,x+radius,y+height-y,x+radius,y+height,opacity);
	ctx.fillStyle=style; ctx.fill();
	ctx.beginPath(); ctx.rect(x+width-(radius*f),y+height-(radius*f),radius*f,radius*f); ctx.closePath();
	style=addRadialStyle(ctx,x+width-(radius*f),y+height-(radius*f),Math.max(0,(radius*f)-1.5-x),x+width-(radius*f),y+height-(radius*f),radius*f,opacity);
	ctx.fillStyle=style; ctx.fill();
	ctx.beginPath(); ctx.moveTo(x+width-x,y+radius); ctx.lineTo(x+width,y+radius); ctx.quadraticCurveTo(x+width-x,y+(height/2),x+width,y+height-(radius*f)); ctx.lineTo(x+width-x,y+height-(radius*f)); ctx.quadraticCurveTo(x+width-(x*2),y+(height/2),x+width-x,y+radius); ctx.closePath();
	style=addLinearStyle(ctx,x+width-x,y+radius,x+width,y+radius,opacity);
	ctx.fillStyle=style; ctx.fill();
	ctx.beginPath(); ctx.rect(x+width-radius,y,radius,radius); ctx.closePath();
	style=addRadialStyle(ctx,x+width-radius,y+radius,radius-x,x+width-radius,y+radius,radius,opacity);
	ctx.fillStyle=style; ctx.fill();
}
function getRadius(radius,width,height){
	var part = (Math.min(width,height)/100);
	radius = Math.max(Math.min(100,radius/part),0);
	return radius+'%';
}
function wavedRect(ctx,x,y,w,h,r,n){
	function rF(a,z) {return Math.random()*(z-a)+a;}
	var i,t,c,cx,cy,cw,ch,wa=w/16,wz=w/32,ha=h/16,hz=h/32,da=r*0.1,dz=r*0.25; if(!n) {ctx.beginPath();} ctx.moveTo(x,y);
	cx=x; cy=y; ch=h; while(ch>0) {t=rF(ha,Math.min(ch,hz)); c=rF(1,t); ctx.quadraticCurveTo(cx+rF(da,dz),cy+c,cx,cy+t); cy+=t; ch-=t;}
	cx=x; cy=y+h; cw=w; while(cw>0) {t=rF(wa,Math.min(cw,wz)); c=rF(1,t); ctx.quadraticCurveTo(cx+c,cy-rF(da,dz),cx+t,cy); cx+=t; cw-=t;}
	cx=x+w; cy=y+h; ch=h; while(ch>0) {t=rF(ha,Math.min(ch,hz)); c=rF(1,t); ctx.quadraticCurveTo(cx-rF(da,dz),cy-c,cx,cy-t); cy-=t; ch-=t;}
	cx=x+w; cy=y; cw=w; while(cw>0) {t=rF(wa,Math.min(cw,wz)); c=rF(1,t); ctx.quadraticCurveTo(cx-c,cy+rF(da,dz),cx-t,cy); cx-=t; cw-=t;}
	if(!n) ctx.closePath();
}
function wavedPath(x,y,w,h,r){
	function rI(a,b) {return parseInt(Math.floor(Math.random()*(b-a+1))+a);}
	function qC(cX,cY,CPx,CPy,aX,aY) {var z=new Array(6); z[0]=cX+2.0/3.0*(CPx-cX); z[1]=cY+2.0/3.0*(CPy-cY); z[2]=z[0]+(aX-cX)/3.0; z[3]=z[1]+(aY-cY)/3.0; z[4]=aX; z[5]=aY; return z;}
	var p="",i,k,t,c,cx,cy,cw,ch,wa=w/16,wz=w/32,ha=h/16,hz=h/32,da=r*0.1,dz=r*0.25; 
	p+='m '+x+','+y; cx=x; cy=y; ch=h; while(ch>0) {t=rI(ha,Math.min(ch,hz)); c=rI(1,t); k=qC(cx,cy,cx+rI(da,dz),cy+c,cx,cy+t); 
	p+=' c '+parseInt(k[0])+','+Math.min(h,parseInt(k[1]))+','+parseInt(k[2])+','+Math.min(h,parseInt(k[3]))+','+parseInt(k[4])+','+Math.min(h,parseInt(k[5]));	cy+=t; ch-=t;}
	cx=x; cy=y+h; cw=w; while(cw>0) {t=rI(wa,Math.min(cw,wz)); c=rI(1,t); k=qC(cx,cy,cx+c,cy-rI(da,dz),cx+t,cy); 
	p+=' c '+Math.min(w,parseInt(k[0]))+','+parseInt(k[1])+','+Math.min(w,parseInt(k[2]))+','+parseInt(k[3])+','+Math.min(w,parseInt(k[4]))+','+parseInt(k[5]); cx+=t; cw-=t;}
	cx=x+w; cy=y+h; ch=h; while(ch>0) {t=rI(ha,Math.min(ch,hz)); c=rI(1,t); k=qC(cx,cy,cx-rI(da,dz),cy-c,cx,cy-t); 
	p+=' c '+parseInt(k[0])+','+Math.max(0,parseInt(k[1]))+','+parseInt(k[2])+','+Math.max(0,parseInt(k[3]))+','+parseInt(k[4])+','+Math.max(0,parseInt(k[5])); cy-=t; ch-=t;}
	cx=x+w; cy=y; cw=w; while(cw>0) {t=rI(wa,Math.min(cw,wz)); c=rI(1,t); k=qC(cx,cy,cx-c,cy+rI(da,dz),cx-t,cy); 
	p+=' c '+Math.max(0,parseInt(k[0]))+','+parseInt(k[1])+','+Math.max(0,parseInt(k[2]))+','+parseInt(k[3])+','+Math.max(0,parseInt(k[4]))+','+parseInt(k[5]); cx-=t; cw-=t;}
	return p+' x e';	
}
function roundedRect(ctx,x,y,width,height,radius,nopath){
	if (!nopath) ctx.beginPath();
	ctx.moveTo(x,y+radius);
	ctx.lineTo(x,y+height-radius);
	ctx.quadraticCurveTo(x,y+height,x+radius,y+height);
	ctx.lineTo(x+width-radius,y+height);
	ctx.quadraticCurveTo(x+width,y+height,x+width,y+height-radius);
	ctx.lineTo(x+width,y+radius);
	ctx.quadraticCurveTo(x+width,y,x+width-radius,y);
	ctx.lineTo(x+radius,y);
	ctx.quadraticCurveTo(x,y,x,y+radius);
	if (!nopath) ctx.closePath();
}

function addIEInstant() {
	var theimages = getImages('instant');
	var image; var object; var vml; var display;
	var border = 16; var offset = 8; var scale = 1;
	var icolor = ''; var ishadow = 0; var noshading;
	var itiltright; var itiltnone;  var itiltleft;
	var itxttitle; var itxtalt; var itxtcol; var text=""; 
	var color = ''; var tilt = 'r'; var opacity = 0; var tw;
	var preserve, tcolor, head, foot, frame, fill, shadow, shade, txt, over, shine;
	var classes = ''; var newClasses = ''; var path, historical, nocorner;
	var inset = 6; var i, f, r, db, hz, flt, ww, hh, ff, yo, xo;
	for(i=0;i<theimages.length;i++) {
		image = theimages[i]; object = image.parentNode; historical = 0;
		itxtalt = 0; itxttitle = 0; text=""; tcolor = '#000000'; nocorner = 0;
		opacity = 0.33; color = '#f0f4ff'; preserve = 0; path=""; over=""; txt=""; 
		itiltright = 0; itiltnone = 0; itiltleft = 0; noshading = 0;
		if(image.width>=64 && image.height>=64) {
			classes = image.className.split(' ');
			ishadow = getClassValue(classes,"ishadow");
			if(ishadow>0) opacity=ishadow/100;
			icolor = getClassColor(classes,"icolor");
			if(icolor!==0) color = icolor;
			itxtcol = getClassColor(classes,"itxtcol");
			if(itxtcol!==0) tcolor = itxtcol;
			itxttitle = getClassAttribute(classes,"itxttitle");
			itxtalt = getClassAttribute(classes,"itxtalt");
			itiltleft = getClassAttribute(classes,"itiltleft");
			itiltright = getClassAttribute(classes,"itiltright");
			itiltnone = getClassAttribute(classes,"itiltnone");
			historical = getClassAttribute(classes,"historical");
			noshading = getClassAttribute(classes,"noshading");
			nocorner = getClassAttribute(classes,"nocorner");
			preserve = getClassAttribute(classes,"preserve");
			if(historical===true) nocorner = false;
			if(itiltright===true) tilt = 'r';
			if(itiltnone===true) tilt = 'n';
			if(itiltleft===true) tilt = 'l';
			newClasses = getClasses(classes,"instant");
			width = image.width; height = image.height;
			border = Math.round(((width+height)/2)*0.05); db=border;
			offset = border/2; inset = parseInt(offset*.75);
			ww=width-(border*2); hh=height-(border*2); hz=Math.round(hh/3);
			f=(noshading===0?"t":"f"); r=nocorner?getRadius(border,width,height):0;
			if(tilt=='r') {
				rotation = 2.8; scale = 0.95; tilt = 'n';
			}else if(tilt=='n') {
				rotation = 0; scale = 1; tilt = 'l';
			}else if(tilt=='l') {
				rotation = -2.8; scale = 0.95; tilt = 'r';
			}
			display = (image.currentStyle.display.toLowerCase()=='block')?'block':'inline-block';        
			vml = document.createElement(['<var style="zoom:1;overflow:hidden;display:' + display + ';width:' + width + 'px;height:' + height + 'px;padding:0px;">'].join(''));
			flt = image.currentStyle.styleFloat.toLowerCase();
			display = (flt=='left'||flt=='right')?'inline':display;
			text = image.alt!==''&&itxtalt!==0?image.alt:image.title!==''&&itxttitle!==0?image.title:'';
			head = '<v:group style="rotation:' + rotation + '; zoom:' + scale + '; display:' + display + '; margin:-1px 0 0 -1px; padding:0px; position:relative; width:'+width+'px;height:'+height+'px;" coordsize="'+width+','+height+'"><v:rect strokeweight="0" filled="f" stroked="f" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:0px;left:0px;width:'+width+'px;height:'+height+'px;"><v:fill opacity="0" color="#000000" /></v:rect>';
			shadow = '<v:roundrect arcsize="'+r+'" strokeweight="0" filled="t" stroked="f" fillcolor="#000000" style="filter:progid:dxImageTransform.Microsoft.Blur(PixelRadius='+inset+', MakeShadow=false) progid:dxImageTransform.Microsoft.Alpha(opacity='+(opacity*100)+'); zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+offset+'px;left:'+offset+'px;width:'+(width-(2*offset))+'px;height:'+(height-(2*offset))+'px;"><v:fill color="#000000" opacity="1" /></v:roundrect>';
			if(historical===0) {
				frame = '<v:roundrect arcsize="'+r+'" strokeweight="0" filled="t" stroked="f" fillcolor="'+color+'" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:0px;left:0px;width:'+(width-offset)+'px;height:'+(height-offset)+'px;"></v:roundrect>';
			}else {path = wavedPath(0,0,(width-offset)*10,(height-offset)*10,border*10);
				frame = '<v:shape strokeweight="0" stroked="f" filled="t" fillcolor="'+color+'" coordorigin="0,0" coordsize="'+((width-offset)*10)+','+((height-offset)*10)+'" path="'+path+'" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:0px;left:0px;width:'+(width-offset)+'px;height:'+(height-offset)+'px;"></v:shape>';
			}
			shine = '<v:rect strokeweight="0" filled="t" stroked="f" fillcolor="' + color + '" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+db+'px;left:'+db+'px;width:' + (width-offset-(2*border)) + 'px;height:' + (height-offset-(2*border)) + 'px;"><v:fill color="#000000" opacity="' + opacity + '" /></v:rect>';
			if(typeof check_strokeTextCapability=='function' && check_strokeTextCapability() && text!=='') {				
				over = '<v:rect strokeweight="0" filled="t" stroked="f" fillcolor="'+color+'" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;left:'+(border-1)+'px;top:'+(height-1-offset-(border*(document.documentMode==8&&rotation!==0?4:3)))+'px;width:'+(width-offset+2-(border*2))+'px;height:'+(border*3)+'px;"></v:rect>';
				text = get_widthText(text,ww,border*1.5,100,100); tw = get_textWidth(text,border*1.5,100,100); 
				txt = get_strokeText(text,((width-offset)-tw)/2,height-offset-(border*(document.documentMode==8&&rotation!==0?3.4:2.4)),border*1.5,100,100,100,"sans-serif",tcolor,1,0);
				shade = '<v:rect strokeweight="0" filled="'+f+'" stroked="f" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+db+'px;left:'+db+'px;width:'+(width-offset-(2*border))+'px;height:'+hz+'px;"><v:fill method="sigma" type="gradient" angle="0" color="#000000" opacity="0" color2="#000000" o:opacity2="'+(opacity/2)+'" /></v:rect><v:rect strokeweight="0" filled="'+f+'" stroked="f" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+(height-offset-(border*3)-hz)+'px;left:'+border+'px;width:'+(width-offset-(2*border))+'px;height:'+hz+'px;"><v:fill method="sigma" type="gradient" angle="0" color="#ffffff" opacity="'+(opacity*0.75)+'" color2="#ffffff" o:opacity2="0" /></v:rect><v:rect strokeweight="2" filled="f" stroked="t" strokecolor="'+color+'" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+border+'px;left:'+border+'px;width:'+(width-offset-(2*border))+'px;height:'+(height-offset-(4*border))+'px;"><v:fill color="#ffffff" opacity="0" /></v:rect>';
			}else {
				shade = '<v:rect strokeweight="0" filled="'+f+'" stroked="f" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+db+'px;left:'+db+'px;width:'+(width-offset-(2*border))+'px;height:'+hz+'px;"><v:fill method="sigma" type="gradient" angle="0" color="#000000" opacity="0" color2="#000000" o:opacity2="'+(opacity/2)+'" /></v:rect><v:rect strokeweight="0" filled="'+f+'" stroked="f" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+(height-offset-border-hz)+'px;left:'+border+'px;width:'+(width-offset-(2*border))+'px;height:'+hz+'px;"><v:fill method="sigma" type="gradient" angle="0" color="#ffffff" opacity="'+(opacity*0.75)+'" color2="#ffffff" o:opacity2="0" /></v:rect><v:rect strokeweight="2" filled="f" stroked="t" strokecolor="'+color+'" fillcolor="transparent" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+border+'px;left:'+border+'px;width:'+(width-offset-(2*border))+'px;height:'+(height-offset-(2*border))+'px;"><v:fill color="#ffffff" opacity="0" /></v:rect>';
			}
			if(preserve===0) {
				fill = '<v:image src="'+image.src+'" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+db+'px;left:'+db+'px;width:'+(width-offset-(2*border))+'px;height:'+(height-offset-(2*border))+'px;"></v:image>';
			}else {
				if(width>height) {
					ff=(height/width); xo=0; yo=((ww*ff)-hh)/2; hh=(ww*ff); yo=(yo/(hh/100));
				}else if(width<height) {
					ff=(width/height); yo=0; xo=((hh*ff)-ww)/2; ww=(hh*ff); xo=(xo/(ww/100));
				}else {
					ff=1; xo=0; yo=0;
				}
				fill = '<v:image croptop="'+yo+'%" cropbottom="'+yo+'%" cropleft="'+xo+'%" cropright="'+xo+'%" src="'+image.src+'" style="zoom:1;margin:0px;padding:0px;display:block;position:absolute;top:'+db+'px;left:'+db+'px;width:'+(width-offset-(2*border))+'px;height:'+(height-offset-(2*border))+';px"></v:image>';
			}
			foot = '</v:group>';
			vml.innerHTML = head+shadow+frame+shine+fill+shade+over+txt+foot;
			vml.className = newClasses;
			vml.style.cssText = image.style.cssText;
			vml.style.visibility = 'visible';
			vml.src = image.src; vml.alt = image.alt;
			vml.width = image.width; vml.height = image.height;
			if(image.id!=='') vml.id = image.id;
			if(image.title!=='') vml.title = image.title;
			if(image.getAttribute('onclick')!=='') vml.setAttribute('onclick',image.getAttribute('onclick'));
			object.replaceChild(vml,image);
		}
	}
}

function addInstant() {
	var theimages = getImages('instant'); 
	var image; var object; var canvas; var context;  
	var border = 16; var offset = 8; var inset = 2; 
	var icolor = ''; var ishadow = 0; var noshading; 
	var itiltright; var itiltnone; var itiltleft;
	var itxttitle; var itxtalt; var itxtcol; var text=""; var tw;
	var color = ''; var tilt = 'r'; var opacity = 0; var db; 
	var classes = ''; var newClasses = ''; var style = '';
	var scale = 0; var xscale = 1; var yscale = 1;
	var i, ww, hh, ff, yo, xo, tcolor, nocorner, historical, preserve;	
	for(i=0;i<theimages.length;i++) {	
		image = theimages[i]; object = image.parentNode; 
		canvas = document.createElement('canvas'); historical = 0;
		itxtalt = 0; itxttitle = 0; text=""; tcolor = '#000000';
		opacity = 0.33; color = '#f0f4ff';  preserve = 0; nocorner = 0; 
		itiltright = 0; itiltnone = 0; itiltleft = 0; noshading = 0;
		if(canvas.getContext && image.width>=64 && image.height>=64) {
			classes = image.className.split(' '); 
			ishadow = getClassValue(classes,"ishadow");
			if(ishadow>0) opacity=ishadow/100;
			icolor = getClassColor(classes,"icolor");
			if(icolor!==0) color = icolor;
			itiltleft = getClassAttribute(classes,"itiltleft");
			itiltright = getClassAttribute(classes,"itiltright");
			itiltnone = getClassAttribute(classes,"itiltnone");
			itxtcol = getClassColor(classes,"itxtcol");
			if(itxtcol!==0) tcolor = itxtcol;
			itxttitle = getClassAttribute(classes,"itxttitle");
			itxtalt = getClassAttribute(classes,"itxtalt");
			historical = getClassAttribute(classes,"historical");
			noshading = getClassAttribute(classes,"noshading");
			nocorner = getClassAttribute(classes,"nocorner");
			preserve = getClassAttribute(classes,"preserve");
			if(historical===true) nocorner = false;
			if(itiltright===true) tilt = 'r';
			if(itiltnone===true) tilt = 'n';
			if(itiltleft===true) tilt = 'l';
			newClasses = getClasses(classes,"instant");
			canvas.className = newClasses;
			canvas.style.cssText = image.style.cssText;
			canvas.style.height = image.height+'px';
			canvas.style.width = image.width+'px';
			canvas.height = image.height;
			canvas.width = image.width;
			canvas.src = image.src; canvas.alt = image.alt;
			if(image.id!=='') canvas.id = image.id;
			if(image.title!=='') canvas.title = image.title;
			if(image.getAttribute('onclick')!=='') canvas.setAttribute('onclick',image.getAttribute('onclick'));
			text = canvas.alt!==''&&itxtalt!==0?canvas.alt:canvas.title!==''&&itxttitle!==0?canvas.title:'';
			border = Math.round(((canvas.width+canvas.height)/2)*0.05); db = Math.round(Math.max(canvas.width,canvas.height)*0.05); 
			offset = border/2; ww=canvas.width-(border*2); hh=canvas.height-(border*2);
			inset = Math.floor(Math.min(Math.max(border/8,1),2));
			if(canvas.width>canvas.height) {
				xscale = 0.05; yscale = xscale*(canvas.width/canvas.height);
			}else if(canvas.width<canvas.height) {
				yscale = 0.05; xscale = yscale*(canvas.height/canvas.width);
			}else {xscale = 0.05; yscale = 0.05;}
			context = canvas.getContext("2d");
			object.replaceChild(canvas,image);
			context.clearRect(0,0,canvas.width,canvas.height);
			context.save(); scale = 1.333333; 
			if(tilt=='r') {
				context.translate(db,0);
				context.scale(1-(scale*xscale),1-(scale*yscale));
				context.rotate(0.05); tilt = 'n';
			}else if(tilt=='n') {
				scale = 1.5; tilt = 'l';
				context.scale(1-(xscale/scale),1-(yscale/scale));
			}else if(tilt=='l') {
				context.translate(0,db);
				context.scale(1-(scale*xscale),1-(scale*yscale));
				context.rotate(-0.05); tilt = 'r';
			}
			tiltShadow(context,offset,offset,canvas.width,canvas.height,offset,opacity,nocorner);
			if(historical==1) {wavedRect(context,0,0,canvas.width,canvas.height,border); context.clip(); }else
			if(nocorner==1) {roundedRect(context,0,0,canvas.width,canvas.height,border); context.clip(); }
			context.fillStyle = color;
			context.fillRect(0,0,canvas.width,canvas.height);
			context.fillStyle = 'rgba(0,0,0,'+opacity+')';
			context.fillRect(border,border,canvas.width-(border*2),canvas.height-(border*2));
			if(!window.opera) addLining(context,1.5,1.5,canvas.width-3,canvas.height-3,opacity,inset,false,color);
			if(preserve===0) {
				context.drawImage(image,border,border,canvas.width-(border*2),canvas.height-(border*2));
			}else {
				if(canvas.width>canvas.height) {
					ff=(canvas.height/canvas.width); xo=0; yo=((ww*ff)-hh)/2; hh=(ww*ff);
				}else if(canvas.width<canvas.height) {
					ff=(canvas.width/canvas.height); yo=0; xo=((hh*ff)-ww)/2; ww=(hh*ff);
				}else {
					ff=1; xo=0; yo=0;
				}
				context.save();
				context.beginPath();  
				context.rect(border,border,ww-(2*xo),hh-(2*yo));
				context.closePath();
				context.clip();
				context.drawImage(image,border-xo,border-yo,ww,hh);
				context.restore();
			}
			if(typeof set_textRenderContext=='function' && text!=='') {
				set_textRenderContext(context);
				if(check_textRenderContext(context)) {
					context.save();
					context.beginPath(); context.rect(1,canvas.height-(border*3),canvas.width-2,(border*3)); context.closePath(); context.fillStyle = color; context.fill();
					context.restore(); 
					if(noshading===0) addShading(context,border,border,canvas.width-(border*2),canvas.height-(border*4),opacity);
					if(!window.opera) addLining(context,border,border,canvas.width-(border*2),canvas.height-(border*4),opacity,inset,true);
					context.strokeStyle = tcolor; text=get_widthText(text,ww,border*1.5,100,100); tw=get_textWidth(text,border*1.5,100,100);
					context.strokeText(text,border+((ww-tw)/2),canvas.height-(border*2.4),border*1.5,100,100,100);
				}
			}else {
				if(noshading===0) addShading(context,border,border,canvas.width-(border*2),canvas.height-(border*2),opacity);
				if(!window.opera) addLining(context,border,border,canvas.width-(border*2),canvas.height-(border*2),opacity,inset,true);
			}
			context.restore();
			canvas.style.visibility = 'visible';
		}
	}
}

if(window.addEventListener) window.addEventListener("load",addInstant,false);
else window.attachEvent("onload",addIEInstant);