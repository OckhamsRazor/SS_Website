var xmlDoc;
//var arr;
function importXML(url) {
	if (document.implementation && document.implementation.createDocument) {
		xmlDoc = document.implementation.createDocument("", "", null);
		xmlDoc.onload = loadXML;
	}
	else if (window.ActiveXObject) {
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.onreadystatechange = function () {
			if (xmlDoc.readyState == 4) loadXML();
		};
	}
	else {
		alert('Your browser can\'t handle this script');
		return;
	}
	xmlDoc.load(url);
}
function loadXML() {
//	for(ent in xmlDoc)
//		alert(ent+'::'+xmlDoc[ent]);
	var x = xmlDoc.getElementsByTagName('time');
	arr = new Array();
//	alert(x.length);
	for (i=0;i<x.length;i++)
	{
		var k = 0;
//		alert(x[i].childNodes);
		arr[i] = new Array();
		for (j=0;j<x[i].childNodes.length;j++) {
			if (x[i].childNodes[j].nodeType != 1) continue;
			arr[i][k] = x[i].childNodes[j].firstChild.nodeValue;
//			alert(i+','+k+':'+arr[i][k]);
			k++;
		}
	}
	return arr;
}
