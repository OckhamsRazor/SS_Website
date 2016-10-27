function createList(obj) 
{
	for(ent in lectureList)
	{
		var cDiv = document.createElement('div');	// The main div for Each Lecture
		cDiv.id = ent;
		cDiv.className = 'lecture_main';
		cDiv.onclick = function(e){
			unfold(e);
		};
		var hline = document.createElement('h3');	// The Main Title for Each Lecture
		hline.innerHTML = 'Chapter ' + ent;
		cDiv.appendChild(hline);
		var subDiv = document.createElement('div');	//	The sub-container for Each Lecture
		subDiv.id = 'sub' + ent;
		subDiv.className = 'lecture_subContainer';
		cDiv.appendChild(subDiv);
		
		document.getElementById(obj).appendChild(cDiv);
	}
};
var unfoldid = '';
function unfold(e) 
{
	var targ;
	e = e || window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if(targ.tagName == 'H3') targ = targ.parentNode;
//	if(targ.tagName == 'IMG') targ = targ.parentNode;
	
	if(unfoldid == targ.id)							// fold the current div
	{
		document.getElementById('sub'+unfoldid).style.display = 'none';
		document.getElementById(targ.id).className = 'lecture_main';
		unfoldid = '';		
		document.getElementById('slides').scrollTop = document.getElementById(targ.id).offsetTop;
		return;
	}
	else if(document.getElementById(unfoldid))		// fold the last div	
	{
		document.getElementById('sub'+unfoldid).style.display = 'none';
		document.getElementById(unfoldid).className = 'lecture_main';
	}
	// envisible the exist div	
	if(document.getElementById('sub'+targ.id).childNodes.length > 0)
	{
		document.getElementById('sub'+targ.id).style.display = 'block';
		document.getElementById(targ.id).className = 'lecture_main_sel';
		unfoldid = targ.id;
		document.getElementById('slides').scrollTop = document.getElementById(targ.id).offsetTop;
		return;
	}
	var basePath = 'slides/DSP/';
	// fill in sub-element of lecture
	for(ent in lectureList[targ.id])
	{
		var subDiv = document.createElement('div');
		document.getElementById(targ.id).className = 'lecture_main_sel';
		subDiv.id = lectureList[targ.id][ent];
		subDiv.className = 'sub_entry';
		
		var hsa = document.createElement('a');
		hsa.id = 'thumb' + lectureList[targ.id][ent];
		hsa.href = basePath + lectureList[targ.id][ent] + '.jpg';
		hsa.className = 'highslide';
		hsa.onclick = function() {
			return hs.expand(this);
			return hs.expand(this, galleryOptions);
		};
//		var img = document.createElement('img');
//		img.src = basePath + lectureList[targ.id][ent] + '.jpg';
//		hsa.appendChild(img);
//		subDiv.appendChild(hsa);
		
		var h4a = document.createElement('h4');
		h4a.innerHTML = 'Chapter' + lectureList[targ.id][ent];
//		h4a.href='./play.php?lecture=DSP&chapter=' + lectureList[targ.id][ent];
		hsa.appendChild(h4a);
		subDiv.appendChild(hsa);
//		subDiv.appendChild(h4a);
		document.getElementById('sub'+targ.id).appendChild(subDiv);
	}
	unfoldid = targ.id;
	document.getElementById('slides').scrollTop = document.getElementById(targ.id).offsetTop;
//	popProp(document.getElementById(targ.id));
};
