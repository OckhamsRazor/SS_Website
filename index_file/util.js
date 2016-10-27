function init(){
	alert("XD");
	var chap = chapter.split('-');
	firstSlide = parseInt(chap[1]) - (slideLength - 1) / 2;
	if(firstSlide < 1) firstSlide = 1;
	displaySlide(document.getElementById('slideContainer'));
	var shower = document.getElementById('shower');
	shower.src = '../slides/DSP/'+chapter+'.jpg';
	var arrow = document.getElementById('lArrow');
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
	var slides = document.getElementById('slideContainer').getElementsByTagName('img');
	for(var i = 0; i < slides.length; i++){
		var node = slides[i];
		if(node.className == 'slide')
			node.onclick = function(){
				changeShower(this);	
			};
	}
}
var slideLength = 5;
function changeShower(obj){
	document.getElementById('shower').src = obj.src;
}
function displaySlide(slide_obj){
	var nodes = slide_obj.getElementsByTagName('img');
	for(var i = 0; i < nodes.length; i++){
		var node = nodes[i];
		if(node.className == 'arrow')
			continue;
		if(i < firstSlide || i >= (firstSlide + slideLength))
			node.style.display = 'none';
		else
			node.style.display = 'block';
	}
}
function slideLeft(slide_obj){
	firstSlide--;
	document.getElementById('rArrow').style.visibility = 'visible';
	if(firstSlide <= 0){
		firstSlide = 1;
		document.getElementById('lArrow').style.visibility = 'hidden';
	}
	displaySlide(slide_obj);
}
function slideRight(slide_obj){
	firstSlide++;
	document.getElementById('lArrow').style.visibility = 'visible';
	if((firstSlide+slideLength) >= maxSlides){
		firstSlide = maxSlides - slideLength - 1;
		document.getElementById('rArrow').style.visibility = 'hidden';
	}
	displaySlide(slide_obj);
}

function display (id, segtime, untiltime, alltime){
	var imagesize = 480;
	var currWidth = (segtime/alltime) * (imagesize);
	var untilWidth = (untiltime/alltime) * (imagesize);
	var afterWidth = (imagesize) - currWidth - untilWidth;
	document.write('<div class=\'progress\' id=\''+id+'\'>');
	document.write('<div class=\'progress_out\' style=\'width:'+untilWidth+'px\'></div>');
	document.write('<div class=\'progress_in\' style=\'width:'+currWidth+'px\'></div>');
	document.write('<div class=\'progress_out\' style=\'width:'+afterWidth+'px\'></div>
	document.write('</div>');
}
