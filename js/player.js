var start = 0;
var ts_i = 0;			// 紀??TimeStamp??index
var currentPosition = 0; 
var isPlayAbstract = 0;
var player = null;
var arr;
var nowPlaying = -1;
var nowSlide = 0;
var video_len;
function lecture_next(){
	nowSlide ++;
	if(ischapter && slide_list[nowSlide] == null){
		document.movie1.Stop();
		ts_i = 0;
		nowSlide = 0;
		isPlayAbstract = 0;
	}
	if(slide_list[nowSlide] == null){
		document.movie1.Stop();
		isPlayAbstract = 0;
		nowSlide = 0;
		ts_i = 0;
	}
	QT_GoToChap(slide_list[nowSlide]);
}
/* define function that adds another function as a DOM event listener */
function myAddListener(obj, evt, handler, captures)
{ 
	if ( document.addEventListener )
		obj.addEventListener(evt, handler, captures);
	else
		// IE
		obj.attachEvent('on' + evt, handler);
}
/* define functions that register each listener */
function RegisterListener(eventName, objID, embedID, listenerFcn) {
	var obj = document.getElementById(objID);
	if ( !obj )
		obj = document.getElementById(embedID);
	if ( obj )
		myAddListener(obj, eventName, listenerFcn, false);
}
/* define a single function that registers all listeners to call onload */
function RegisterListeners() {
	RegisterListener('qt_ended', 'movie1', 'movie1', lecture_next);
	setInterval("positionListener()",1000);
}

function QT_GoTo(sec){
//	var sec = document.getElementById('sec').value;
	var t_scale = document.movie1.GetTimeScale();
	document.movie1.Stop();
	document.movie1.SetTime(sec*t_scale);
	document.movie1.Play();
}
function QT_GoToChap(chap){
//	var chap = document.getElementById('chap').value;
	document.movie1.Stop();
	document.movie1.SetURL('http://140.112.21.32/'+chap+'.mp4');
	var img = document.getElementById('slideImg');
	img.src = "slides/DSP/"+chap+".jpg";
	setTimeout('QT_Update_Process()', 1000);
	document.movie1.Play();
}

function QT_Update_Process() {
	var container = document.getElementById('process_container');
	var container_width = 235;
	var qt_i = ts_i;
	container.innerHTML = '';
	var pre_length = 0;
	/*
	if play summary is on each slide, not including the main chapter page, then the length of each slide should be calculated at newform.php.
	variable video_len is not equal to 0 when user clicks on single slide page. Otherwise, it will be zero when user clicks on the "Chapter X" button and 
	press the "Play summary" button. (X could be any chapter's number)
	*/
	if(video_len==0){
		video_len = document.movie1.GetDuration() / document.movie1.GetTimeScale();
	}
	while(arr[qt_i]){
		if(arr[qt_i][0] == -1) break;
		if(arr[qt_i][0] > video_len)
			break;
		var node = document.createElement('div');
		node.className = 'is_summary';
		node.style.width = Math.round((arr[qt_i][1] - arr[qt_i][0]) / video_len * container_width);
		node.style.marginLeft = Math.round((arr[qt_i][0] - pre_length) / video_len * container_width);
		pre_length = arr[qt_i][1];
		container.appendChild(node);
		qt_i ++;
	}
}

function positionListener() {
	currentPosition = document.movie1.GetTime()/document.movie1.GetTimeScale(); 
	video_len = document.movie1.GetDuration() / document.movie1.GetTimeScale();
	if(isPlayAbstract) {
		if(ts_i < arr.length) {
			if (arr[ts_i][0] < 0){
				lecture_next();
				arr[ts_i][0] = 0;
				arr[ts_i][1] = 0.2;
				QT_GoTo(arr[ts_i][0]);
				return;
			}
//			if(currentPosition < (arr[ts_i][0] - 35)){
//				QT_GoTo(arr[ts_i][0]);
//			}
			if(currentPosition >= arr[ts_i][1]) {
				ts_i++;
//				if(arr[ts_i][0] < 0) return;
				for(;arr[ts_i][0] > video_len; ts_i++);
//				alert(arr[ts_i][0]+'/'+video_len);
				if(arr[ts_i][0] != -1)
					QT_GoTo(arr[ts_i][0]);
			}
		}
		else
		{
			ts_i = 0;
			nowSlide = 0;
			isPlayAbstract = 0;
			document.movie1.Stop();
		}
	}
	//	if (tmp) { tmp.innerHTML = "position: " + currentPosition; }
}

function QT_Reset(){
	isPlayAbstract = 1;
	QT_GoTo(0);
}

function PlayAbstract(path) {
	isPlayAbstract = 1;
//	importXML(path);
//	player.sendEvent('PLAY');
	setTimeout('QT_GoTo(arr[0][0]);', 200);
}

