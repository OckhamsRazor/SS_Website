function init(){
	maxSlides++;
	var keywordcontainer = document.getElementById('keytermcontainer');
	var keywords = keywordcontainer.getElementsByTagName('div');;
	keywordcontainer.style.width = keywords.length*160;
	var slides = document.getElementById('slideContainer').getElementsByTagName('img');
	for(var i = 0; i < slides.length; i++){
		var node = slides[i];
		if(node.className != 'arrow')
			node.onclick = function(){
				changeShower(this);	
			};
	}
	var chap = chapter.split('-');
	firstSlide = parseInt(chap[1]) - (slideLength - 1) / 2;
	if(firstSlide < 0) firstSlide = 0;
	else if (firstSlide >= maxSlides - slideLength) firstSlide = maxSlides - slideLength;
	displaySlide(document.getElementById('slideContainer'));
	var shower = document.getElementById('shower');
	shower.src = '../slides/DSP/'+chapter+'.jpg';
	var arrow = document.getElementById('lArrow');
	if(firstSlide == 0) arrow.style.visibility = 'hidden';
	arrow.onmouseover = function(){
		var arrow = document.getElementById('lArrow');
		arrow.src = "arrow_bl.png";
	};
	arrow.onmouseout = function(){
		var arrow = document.getElementById('lArrow');
		arrow.src = "arrow_l.png";
	};
	arrow.onclick = function(){
		slideLeft(document.getElementById('slideContainer'));
	};
	arrow = document.getElementById('rArrow');
	if(firstSlide >= maxSlides - slideLength - 1) arrow.style.visibility = 'hidden';
	arrow.onmouseover = function(){
		var arrow = document.getElementById('rArrow');
		arrow.src = "arrow_br.png";
	};
	arrow.onmouseout = function(){
		var arrow = document.getElementById('rArrow');
		arrow.src = "arrow_r.png";
	};
	arrow.onclick = function(){
		slideRight(document.getElementById('slideContainer'));
	};
}
var slideLength = 5;
function changeShower(obj){
	document.getElementById('shower').src = obj.src;
	var nodes = document.getElementById("slideContainer").getElementsByTagName('img');
	for(var i = 0; i < nodes.length; i++){
		var node = nodes[i];
		if(node.className == 'arrow')
			continue;
		node.className = 'slide';
	}
	obj.className = 'slide_curr';
}
function displaySlide(slide_obj){
//	alert(firstSlide+'/'+maxSlides);
	var shower = document.getElementById("shower");
	var nodes = slide_obj.getElementsByTagName('img');
	for(var i = 0; i < nodes.length; i++){
		var node = nodes[i];
		if(node.className == 'arrow')
			continue;
		if(i <= firstSlide || i > (firstSlide + slideLength))
			node.style.display = 'none';
		else
			node.style.display = 'block';
		if(node.src == shower.src)
			node.className="slide_curr";
	}
}
function slideLeft(slide_obj){
	firstSlide--;
	document.getElementById('rArrow').style.visibility = 'visible';
	if(firstSlide <= 0){
		firstSlide = 1;
		document.getElementById('lArrow').style.visibility = 'hidden';
	}
//	alert(firstSlide+'/'+maxSlides);
	displaySlide(slide_obj);
}
function slideRight(slide_obj){
	firstSlide++;
	document.getElementById('lArrow').style.visibility = 'visible';
	if((firstSlide+slideLength) > maxSlides){
		firstSlide = maxSlides - slideLength;
		document.getElementById('rArrow').style.visibility = 'hidden';
	}
//	alert(firstSlide+'/'+maxSlides);
	displaySlide(slide_obj);
}

function display (id, segtime, untiltime, alltime){
	var imagesize = 360;
	var currWidth = (segtime/alltime) * (imagesize);
	var untilWidth = (untiltime/alltime) * (imagesize);
	var afterWidth = (imagesize) - currWidth - untilWidth;
	document.write('<div class=\'progress\' id=\''+id+'\'>');
	document.write('<div class=\'progress_out\' style="width:'+untilWidth+'px"></div>');
	document.write('<div class=\'progress_in\' style="width:'+currWidth+'px"></div>');
//	document.write('<div class=\'progress_out\' style="width:'+afterWidth+'px"></div>');
	document.write('</div>');
}
function getScroll() {
	var t, l, w, h;
	if (document.documentElement && document.documentElement.scrollTop) {
		t = document.documentElement.scrollTop;
		l = document.documentElement.scrollLeft;
		w = document.documentElement.scrollWidth;
		h = document.documentElement.scrollHeight;
	} else if (document.body) {
		t = document.body.scrollTop;
		l = document.body.scrollLeft;
		w = document.body.scrollWidth;
		h = document.body.scrollHeight;
	}
	return { t: t, l: l, w: w, h: h };
} 
