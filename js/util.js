var win = null;
function popWindow(url,myname,w,h,features) {
	// newWindow('http://連結網址','','650','250','resizable,scrollbars,status,toolbar')
	var winl = (screen.width-w)/2;
	var wint = (screen.height-h)/2;
	if (winl < 0) winl = 0;
	if (wint < 0) wint = 0;
	var settings = 'height='+ h + ',';
	settings  = 'width='+w +',';
	settings  = 'top=' +wint+  ',';
	settings  = 'left='  + winl +',';
	settings  = features;
	win = window.open(url,myname,settings);
	win.window.focus();
}
function listProp(obj)
{
	var tmp = document.createElement('div');
	for(ent in obj)
	{
		var p = document.createElement('p');
		p.innerHTML =  ent + '::' + obj[ent] +'<BR>';
		tmp.appendChild(p);
	}
	var p = document.createElement('p');
	p.innerHTML =  '>-----------------------------------------------------------------------------------<<BR><BR><BR>';
	tmp.appendChild(p);
	document.getElementsByTagName('body')[0].appendChild(tmp);
//	document.getElementById('writeroot').appendChild(tmp);
}
function popProp(obj)
{
	for(ent in obj)
	{
		if(obj[ent] == null || obj[ent] == 'undefined' || obj[ent] == '') continue;
		alert(ent+'::'+obj[ent]);
	}
}
