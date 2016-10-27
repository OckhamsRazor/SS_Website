var start = 0;
var ts_i = 0;			// ç´€?„TimeStamp?„index
var currentPosition = 0; 
var currentVolume = 80; 
var isPlayAbstract = 0;
var player = null;
function playerReady(thePlayer) {
	player = window.document[thePlayer.id];
	addListeners();
}


function addListeners() {
	if (player) { 
		player.addModelListener("TIME", "positionListener");
		player.addControllerListener("VOLUME", "volumeListener");
	} else {
		setTimeout("addListeners()",100);
	}
}


function positionListener(obj) { 
	currentPosition = obj.position; 
	//	var tmp = document.getElementById("posit");
	//	if (tmp) { tmp.innerHTML = "position: " + currentPosition; }
	if(isPlayAbstract)
	{
		if(ts_i < arr.length)
		{
			if(start == 0)
			{
				start = arr[ts_i][0]==0? 0.1:arr[ts_i][0];
				//				alert(arr[ts_i][0]+'-->'+arr[ts_i][1]);
				player.sendEvent('SEEK', arr[ts_i][0]);
			}
			else if(currentPosition >= arr[ts_i][1])
			{
				ts_i++;

				//				alert(arr[ts_i][0]+'-->'+arr[ts_i][1]);
				player.sendEvent('SEEK', arr[ts_i][0]);
			}
		}
		else
		{
			start = 0;
			player.sendEvent('STOP');
			ts_i = 0;
			isPlayAbstract = 0;
		}
	}
	//	if (tmp) { tmp.innerHTML = "position: " + currentPosition; }
}


function volumeListener(obj) { 
	currentVolume = obj.percentage; 
	var tmp = document.getElementById("vol");
	if (tmp) { tmp.innerHTML = "volume: " + currentVolume; }
}

function createPlayer(url,t_id, id, width, height, url_summ) {
	var flashvars = {
		//		file:"video/test_s1.m4v", 
file: url,
      autostart:"true"
	}

	var params = {
allowfullscreen:"true", 
		allowscriptaccess:"always"
	}

	var attributes = {
id: id,  
    name: id
	}
	PlayAbstract(url_summ);
	swfobject.embedSWF("player.swf", t_id, width, height, "9.0.115", false, flashvars, params, attributes);
}

function PlayAbstract(path)
{
	//player.sendEvent('PLAY');
	isPlayAbstract = 1;
	importXML(path);
	//	alert(arr[ts_i][0]);
}
