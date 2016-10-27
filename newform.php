<?php
include_once('php/xml2array.php');

$chapter = trim(@$_REQUEST['chapter']);
$chapter_split = split("-", $chapter);
$slide_list = array();
include_once('php/db.php');
include_once('php/calTime.php');
mysql_select_db('lecture');
if(count($chapter_split) < 2){
	$lecture = mysql_query("select * from lecture where chapter_no = '$chapter'");
	$i = 0;
	while ($row = mysql_fetch_array($lecture, MYSQL_BOTH)) {
		$slide_list[$i] = @$row['lecture'];
		$i++;
	}
	mysql_close($link);
}
else{ 
	$slide_list[0] = $chapter;
}
$lecture = @$_REQUEST['lecture'];
$start = @$_REQUEST['start'];
if(isset($_REQUEST['summary']))
	$playSummary = @$_REQUEST['summary'];
else
	$playSummary = false;
$sentence = array();
$xml = array();
if($playSummary) {
	$fpr = fopen(dirname('__FILE__')."/summary/$lecture/$chapter.xml", 'r');
	$data = fread($fpr, 4096);
	$xml = xml2array($data);
	fclose($fpr);
	foreach($xml['timestamp']['time'] as $entry){
             if(isset($entry['sentence'])){
		if(is_array($entry['sentence'])){
			for($j = 0; isset($entry['sentence'][$j]); $j++)
				$sentence[$entry['sentence'][$j]] = 1;
		}
		else
			$sentence[$entry['sentence']] = 1;
             }
	}
}
?>
<html>
<head>
	<meta name="author" content="YY Chung">
	<title>NTU Virtual Instructor</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=big5">
	<style>
	#slide_browser{
		background: white;
		width: 100%;
		height: 100%;
		clear: none;
		float: left;
		display: block;
		overflow-y: auto;
	}
	#trans {
		background: white;
		border-left: 1px solid gray;
		width: 100%;
		clear: none;
		float: left;
		display: block;
		height: 100%;
		overflow-y: auto;
	}
	#trans p{
		line-height: 1em;
	}
	li {
		width: 100%;
	        display: block;
	        clear: both;
	        padding: 1px;
	        text-align: center;
	}
	li a{
	        border: 1px #E4E4CA solid;
	        width: 99%;
		background: #73B7FF;
	        text-decoration: none;
	        display: block;
	        padding: 5px 10px;
	        clear: both;
	        color: white;
	        font-size: 1.1em;
	        cursor: pointer;
	}
	li a:hover {
	        border: 1px #E4E4CA solid;
	        width: 99%;
	        text-decoration: underline;
	        display: block;
	        padding: 5px 10px;
	        clear: both;
	        color: #FF9D37;
		background: #A2CFD0;
	        font-size: 1.2em;
	        cursor: pointer;
	}
	ul { margin-left: -50px; margin-top: 0px;
	}
	.leaf_navigation li {
	        display: block;
	        clear: both;
	        padding: 1px;
	        text-align: center;
	}
	.leaf_navigation li a{
	        border: 1px #E4E4CA solid;
	        width: 100%;
	        text-decoration: none;
	        display: block;
	        padding: 5px 10px;
	        clear: both;
		background: #AFD6FF;
	        color: black;
	        font-size: 1em;
	        cursor: pointer;
	}
	.leaf_navigation li a:hover {
	        border: 1px #E4E4CA solid;
	        width: 100%;
	        text-decoration: underline;
	        display: block;
	        padding: 5px 10px;
	        clear: both;
	        color: #FF9D37;
	        font-size: 1em;
	        cursor: pointer;
	}
	.leaf_navigation ul{
		margin-left: 0px;
	}
	#sidebar{
		position: absolute;
		top: 0px;
		height: 100%;
	}
	#tabcontainer {
		overflow-x: hidden;
		width: 25px;
		float: left;
		display: block;
	}
	#tabcontainer .tab {
		background: #E39D53;
		width: 25px;
		height: auto;
		clear: left;
		margin-bottom: 5px;
	}
	#tabcontainer .tab img{
		background: #E39D53;
		float: left;
		width: 25px;
		height: auto;
		padding: 5px;
		margin-left: 0px;
	}
	#tabcontainer div {width: 10px;}
	#sidecontainer{
		float: left;
		display: block;
		overflow-x: hidden;
		height: 100%;
		width: 152px;
		margin-left: 0px;
	}
	#sidecontainer .sidepage{
		overflow-x: hidden;
		overflow-y: auto;
	}
	#summarytitle {
		position: absolute;
		left: 60px;
		color: white;
		font: normal small-caps bolder Time New Roman;
	}
	#summaryprocess {
		position: absolute;
		left: 10px;
	}
	#summaryprocess a{
		text-decoration: none;
		color: #6DE6E7;
		cursor: pointer;
		clear: left;
		float: left;
	}
	#process_container {
		float: left;
		clear: none;
		margin-left: 8px;
		border: 1px solid white;
		height: 17px;
		width: 235px;
	}

	#process_container .is_summary {
		height: 15px;
		border: 1px solid red;
		background: red;
		float: left;
		clear: none;
	}

	</style>
	<script type="text/javascript" src="js/xml.js"></script>
	<script type="text/javascript" src="js/AC_QuickTime.js"></script>
	<script type="text/javascript" src="js/swfobject.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.corner.js"></script>
	<script type="text/javascript" src="js/player.js"></script>
	<script type="text/javascript">

	<?php
	if($playSummary) {
		echo "var arr=Array();\n";
		for($i = 0; $i < count(@$xml['timestamp']['time']); $i++) {
			echo "arr[$i] = Array('".@$xml['timestamp']['time'][$i]['begin']."','".@$xml['timestamp']['time'][$i]['end']."');\n";
		}
	}
	?>
function PlaySummary(arr, index){
        console.log(arr);
	var myVideo = document.getElementById("myvideo"); 
        if (myVideo.paused) return;
        myVideo.pause();
        
        if(arr.length <= index) return;
	myVideo.currentTime = arr[index][0];
	myVideo.play();
        setTimeout("PlaySummary(arr, " + (index+1) + ")", 1000*(arr[index][1] - arr[index][0]));

}
	var pinged = false;
	var sideshow = false;
	/*
	* Document Initial Action
	* * Hile all leaf div
	* * Bind div event handler
	*/
	$(document).ready(function() {
		$(".leaf_navigation").hide();
		$("#sidecontainer").hide();
		$('.sidepage').hide();
		$('#ping').hide();
		var width = $(window).width();
		var height = $(window).height();
		$('#summarytitle').css('top', height * 0.9);
		$('#sidebar').css('left', width - 30);

		$('.tab').click(function(){
			if($(this).attr('id') == 'ping'){
				if(pinged){
					pinged = false;
					$(this).attr('src', 'img/unping.png');
				} else {
					pinged = true;
					$(this).attr('src', 'img/ping.png');
				}
				return;
			}
			$('#sidecontainer').show();
			$('#ping').show();
			if($(this).attr('id') == 'slide_tab')
				target = $('#slide_browser');
			else
				target = $('#trans');
			$('#sidebar').css('left', width - 180);
			$('.sidepage').hide(); target.show();
		});
		$("#slideImg").mouseover(function(){
			if(!pinged){
				$('#ping').hide();
				$('#sidecontainer').hide();
				$('.sidepage').hide();
				$('#sidebar').css('left', width - 30);
			}
		});
	});
var pop = null;
function popwin(chap){
	if(isNaN(chap)){
		if(pop != null)
			pop.close();
		var href = "slides/DSP/"+chap+".jpg";
		pop = window.open (href,
				"DSP Slide",
				"status=1,width=480,height=360,left=400,top=300");
	}
	else{
		var target = document.getElementById("navigation_slide"+chap);
		if(target.style.display == 'none')
			target.style.display = 'block';
		else
			target.style.display = 'none';
	}
}
var slide_list = Array(<?php
echo "'".$slide_list[0]."'";
for($i = 1; isset($slide_list[$i]) ; $i++)
	echo ", '".$slide_list[$i]."'";
?>
);
var ischapter = <?php if(count($chapter_split) < 2) echo 'true'; else echo 'false';?>;
function init() {

	var myVideo = document.getElementById("myvideo"); 
	myVideo.play();
	/**
	* Body onload action
	* * Bind Quicktime Listeners
	* * (Optional) Trigger Play Summary
	*/
	<?php
        if($playSummary){
              echo "PlaySummary(arr, 0);";
        }

	include_once("config.php");
	$start = ($start >= 0 && $start != '')? $start:0;
	echo "window.document.title = '$lecture Video Lecture -- $chapter';\n";
	echo "RegisterListeners();\n";
	echo "document.movie1.Stop();\n";
	echo "QT_GoTo($start);\n";
//	echo "document.movie1.SetEndTime(".$slide_list[0]['duration'].");\n";
	echo "document.movie1.Play();\n";
	?>
<?php	if($playSummary){

		if(count($chapter_split)>=2){
			$chu_sql='select lecture_len from lecture where lecture="'.$slide_list[0].'" limit 1';
			list($video_len)=mysql_fetch_array(mysql_query($chu_sql));
			list($video_hours,$video_mins,$video_secs)=explode(":",$video_len);
			$video_len=$video_hours*3600+$video_mins*60+$video_secs;
			echo "video_len=".$video_len.";";

		}
			
		//echo "video_len=".$video_len.";\n";
		echo "PlayAbstract('summary/DSP/$chapter.xml');\n"; 
		echo "setTimeout('QT_Update_Process();', 100);\n";

	}?>
}

</script>
<script type="text/javascript">
/*Google Analytics Code*/
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-9001206-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</head>
<body onload="init()">

<video id="myvideo" width="360" height="256" controls>
  <source src="mp4s/<?php echo $slide_list[0];?>.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
<div id="slidesContainer">
<?php
if($playSummary){ 
echo "<div id='summaryprocess'><a onclick='clearTimeout();document.getElementById(\"myvideo\").play();PlaySummary(arr, 0);'>Replay</a><div id='process_container'></div></div>";
echo "<div id='summarytitle'>Playing Summary</div>"; 
} ?>
<?php
$split = split('-', $chapter);
if(count($split) > 1)
	echo "<img id='slideImg' src='slides/$lecture/$chapter.jpg'>"."</img>";
else
	echo "<img id='slideImg' src='slides/$lecture/$chapter-1.jpg'>"."</img>";
?>
</div>

<div id="sidebar">
<div id="tabcontainer">
<img id='ping' class='tab' src='img/unping.png'></img>
<?php
if($start == 0)
{
	if(!$playSummary){
		echo "<img id='slide_tab' class='tab' src='img/slide.png'></img>";
	}
	echo "<img id=\"trans_tab\" class=\"tab\" src='img/trans.png'>";
}
?>
</div>
<div id="sidecontainer">
<div id="slide_browser" class="sidepage" style="display:none;">

<ul class="" id="navigation">
	<li class="">
	<a class="head" onclick="popwin(1)">Chapter 1</a>
	<ul class="leaf_navigation" id="navigation_slide1">
	<li><a class="leaf" onclick="popwin('1-0')">1-0</a></li>
	<li><a class="leaf" onclick="popwin('1-1')">1-1</a></li>
	<li><a class="leaf" onclick="popwin('1-2')">1-2</a></li>
	<li><a class="leaf" onclick="popwin('1-3')">1-3</a></li>
	<li><a class="leaf" onclick="popwin('1-4')">1-4</a></li>
	<li><a class="leaf" onclick="popwin('1-5')">1-5</a></li>
	<li><a class="leaf" onclick="popwin('1-6')">1-6</a></li>
	<li><a class="leaf" onclick="popwin('1-7')">1-7</a></li>
	<li><a class="leaf" onclick="popwin('1-8')">1-8</a></li>
	<li><a class="leaf" onclick="popwin('1-9')">1-9</a></li>
	<li><a class="leaf" onclick="popwin('1-10')">1-10</a></li>
	<li><a class="leaf" onclick="popwin('1-11')">1-11</a></li>
	<li><a class="leaf" onclick="popwin('1-12')">1-12</a></li>
	<li><a class="leaf" onclick="popwin('1-13')">1-13</a></li>
	<li><a class="leaf" onclick="popwin('1-14')">1-14</a></li>
	<li><a class="leaf" onclick="popwin('1-15')">1-15</a></li>
	<li><a class="leaf" onclick="popwin('1-16')">1-16</a></li>
	<li><a class="leaf" onclick="popwin('1-17')">1-17</a></li>
	<li><a class="leaf" onclick="popwin('1-18')">1-18</a></li>
	<li><a class="leaf" onclick="popwin('1-19')">1-19</a></li>
	<li><a class="leaf" onclick="popwin('1-20')">1-20</a></li>
	<li><a class="leaf" onclick="popwin('1-21')">1-21</a></li>
	<li><a class="leaf" onclick="popwin('1-22')">1-22</a></li>
	<li><a class="leaf" onclick="popwin('1-23')">1-23</a></li>
	<li><a class="leaf" onclick="popwin('1-24')">1-24</a></li>
	<li><a class="leaf" onclick="popwin('1-25')">1-25</a></li>
	<li><a class="leaf" onclick="popwin('1-26')">1-26</a></li>
	<li><a class="leaf" onclick="popwin('1-27')">1-27</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(2)">Chapter 2</a>
	<ul class="leaf_navigation" id="navigation_slide2">
	<li><a class="leaf" onclick="popwin('2-0')">2-0</a></li>
	<li><a class="leaf" onclick="popwin('2-1')">2-1</a></li>
	<li><a class="leaf" onclick="popwin('2-2')">2-2</a></li>
	<li><a class="leaf" onclick="popwin('2-3')">2-3</a></li>
	<li><a class="leaf" onclick="popwin('2-4')">2-4</a></li>
	<li><a class="leaf" onclick="popwin('2-5')">2-5</a></li>
	<li><a class="leaf" onclick="popwin('2-6')">2-6</a></li>
	<li><a class="leaf" onclick="popwin('2-7')">2-7</a></li>
	<li><a class="leaf" onclick="popwin('2-8')">2-8</a></li>
	<li><a class="leaf" onclick="popwin('2-9')">2-9</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(3)">Chapter 3</a>
	<ul class="leaf_navigation" id="navigation_slide3">
	<li><a class="leaf" onclick="popwin('3-0')">3-0</a></li>
	<li><a class="leaf" onclick="popwin('3-1')">3-1</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(4)">Chapter 4</a>
	<ul class="leaf_navigation" id="navigation_slide4">
	<li><a class="leaf" onclick="popwin('4-0')">4-0</a></li>
	<li><a class="leaf" onclick="popwin('4-1')">4-1</a></li>
	<li><a class="leaf" onclick="popwin('4-2')">4-2</a></li>
	<li><a class="leaf" onclick="popwin('4-3')">4-3</a></li>
	<li><a class="leaf" onclick="popwin('4-4')">4-4</a></li>
	<li><a class="leaf" onclick="popwin('4-5')">4-5</a></li>
	<li><a class="leaf" onclick="popwin('4-6')">4-6</a></li>
	<li><a class="leaf" onclick="popwin('4-7')">4-7</a></li>
	<li><a class="leaf" onclick="popwin('4-8')">4-8</a></li>
	<li><a class="leaf" onclick="popwin('4-9')">4-9</a></li>
	<li><a class="leaf" onclick="popwin('4-10')">4-10</a></li>
	<li><a class="leaf" onclick="popwin('4-11')">4-11</a></li>
	<li><a class="leaf" onclick="popwin('4-12')">4-12</a></li>
	<li><a class="leaf" onclick="popwin('4-13')">4-13</a></li>
	<li><a class="leaf" onclick="popwin('4-14')">4-14</a></li>
	<li><a class="leaf" onclick="popwin('4-15')">4-15</a></li>
	<li><a class="leaf" onclick="popwin('4-16')">4-16</a></li>
	<li><a class="leaf" onclick="popwin('4-17')">4-17</a></li>
	<li><a class="leaf" onclick="popwin('4-18')">4-18</a></li>
	<li><a class="leaf" onclick="popwin('4-19')">4-19</a></li>
	<li><a class="leaf" onclick="popwin('4-20')">4-20</a></li>
	<li><a class="leaf" onclick="popwin('4-21')">4-21</a></li>
	<li><a class="leaf" onclick="popwin('4-22')">4-22</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(5)">Chapter 5</a>
	<ul class="leaf_navigation" id="navigation_slide5">
	<li><a class="leaf" onclick="popwin('5-0')">5-0</a></li>
	<li><a class="leaf" onclick="popwin('5-1')">5-1</a></li>
	<li><a class="leaf" onclick="popwin('5-2')">5-2</a></li>
	<li><a class="leaf" onclick="popwin('5-3')">5-3</a></li>
	<li><a class="leaf" onclick="popwin('5-4')">5-4</a></li>
	<li><a class="leaf" onclick="popwin('5-5')">5-5</a></li>
	<li><a class="leaf" onclick="popwin('5-6')">5-6</a></li>
	<li><a class="leaf" onclick="popwin('5-7')">5-7</a></li>
	<li><a class="leaf" onclick="popwin('5-8')">5-8</a></li>
	<li><a class="leaf" onclick="popwin('5-9')">5-9</a></li>
	<li><a class="leaf" onclick="popwin('5-10')">5-10</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(6)">Chapter 6</a>
	<ul class="leaf_navigation" id="navigation_slide6">
	<li><a class="leaf" onclick="popwin('6-0')">6-0</a></li>
	<li><a class="leaf" onclick="popwin('6-1')">6-1</a></li>
	<li><a class="leaf" onclick="popwin('6-2')">6-2</a></li>
	<li><a class="leaf" onclick="popwin('6-3')">6-3</a></li>
	<li><a class="leaf" onclick="popwin('6-4')">6-4</a></li>
	<li><a class="leaf" onclick="popwin('6-5')">6-5</a></li>
	<li><a class="leaf" onclick="popwin('6-6')">6-6</a></li>
	<li><a class="leaf" onclick="popwin('6-7')">6-7</a></li>
	<li><a class="leaf" onclick="popwin('6-8')">6-8</a></li>
	<li><a class="leaf" onclick="popwin('6-9')">6-9</a></li>
	<li><a class="leaf" onclick="popwin('6-10')">6-10</a></li>
	<li><a class="leaf" onclick="popwin('6-11')">6-11</a></li>
	<li><a class="leaf" onclick="popwin('6-12')">6-12</a></li>
	<li><a class="leaf" onclick="popwin('6-13')">6-13</a></li>
	<li><a class="leaf" onclick="popwin('6-14')">6-14</a></li>
	<li><a class="leaf" onclick="popwin('6-15')">6-15</a></li>
	<li><a class="leaf" onclick="popwin('6-16')">6-16</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(7)">Chapter 7</a>
	<ul class="leaf_navigation" id="navigation_slide7">
	<li><a class="leaf" onclick="popwin('7-0')">7-0</a></li>
	<li><a class="leaf" onclick="popwin('7-1')">7-1</a></li>
	<li><a class="leaf" onclick="popwin('7-2')">7-2</a></li>
	<li><a class="leaf" onclick="popwin('7-3')">7-3</a></li>
	<li><a class="leaf" onclick="popwin('7-4')">7-4</a></li>
	<li><a class="leaf" onclick="popwin('7-5')">7-5</a></li>
	<li><a class="leaf" onclick="popwin('7-6')">7-6</a></li>
	<li><a class="leaf" onclick="popwin('7-7')">7-7</a></li>
	<li><a class="leaf" onclick="popwin('7-8')">7-8</a></li>
	<li><a class="leaf" onclick="popwin('7-9')">7-9</a></li>
	<li><a class="leaf" onclick="popwin('7-10')">7-10</a></li>
	<li><a class="leaf" onclick="popwin('7-11')">7-11</a></li>
	<li><a class="leaf" onclick="popwin('7-12')">7-12</a></li>
	<li><a class="leaf" onclick="popwin('7-13')">7-13</a></li>
	<li><a class="leaf" onclick="popwin('7-14')">7-14</a></li>
	<li><a class="leaf" onclick="popwin('7-15')">7-15</a></li>
	<li><a class="leaf" onclick="popwin('7-16')">7-16</a></li>
	<li><a class="leaf" onclick="popwin('7-17')">7-17</a></li>
	<li><a class="leaf" onclick="popwin('7-18')">7-18</a></li>
	<li><a class="leaf" onclick="popwin('7-19')">7-19</a></li>
	<li><a class="leaf" onclick="popwin('7-20')">7-20</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(8)">Chapter 8</a>
	<ul class="leaf_navigation" id="navigation_slide8">
	<li><a class="leaf" onclick="popwin('8-0')">8-0</a></li>
	<li><a class="leaf" onclick="popwin('8-1')">8-1</a></li>
	<li><a class="leaf" onclick="popwin('8-2')">8-2</a></li>
	<li><a class="leaf" onclick="popwin('8-3')">8-3</a></li>
	<li><a class="leaf" onclick="popwin('8-4')">8-4</a></li>
	<li><a class="leaf" onclick="popwin('8-5')">8-5</a></li>
	<li><a class="leaf" onclick="popwin('8-6')">8-6</a></li>
	<li><a class="leaf" onclick="popwin('8-7')">8-7</a></li>
	<li><a class="leaf" onclick="popwin('8-8')">8-8</a></li>
	<li><a class="leaf" onclick="popwin('8-9')">8-9</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(9)">Chapter 9</a>
	<ul class="leaf_navigation" id="navigation_slide9">
	<li><a class="leaf" onclick="popwin('9-0')">9-0</a></li>
	<li><a class="leaf" onclick="popwin('9-1')">9-1</a></li>
	<li><a class="leaf" onclick="popwin('9-2')">9-2</a></li>
	<li><a class="leaf" onclick="popwin('9-3')">9-3</a></li>
	<li><a class="leaf" onclick="popwin('9-4')">9-4</a></li>
	<li><a class="leaf" onclick="popwin('9-5')">9-5</a></li>
	<li><a class="leaf" onclick="popwin('9-6')">9-6</a></li>
	<li><a class="leaf" onclick="popwin('9-7')">9-7</a></li>
	<li><a class="leaf" onclick="popwin('9-8')">9-8</a></li>
	<li><a class="leaf" onclick="popwin('9-9')">9-9</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(10)">Chapter 10</a>
	<ul class="leaf_navigation" id="navigation_slide10">
	<li><a class="leaf" onclick="popwin('10-0')">10-0</a></li>
	<li><a class="leaf" onclick="popwin('10-1')">10-1</a></li>
	<li><a class="leaf" onclick="popwin('10-2')">10-2</a></li>
	<li><a class="leaf" onclick="popwin('10-3')">10-3</a></li>
	<li><a class="leaf" onclick="popwin('10-4')">10-4</a></li>
	<li><a class="leaf" onclick="popwin('10-5')">10-5</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(11)">Chapter 11</a>
	<ul class="leaf_navigation" id="navigation_slide11">
	<li><a class="leaf" onclick="popwin('11-0')">11-0</a></li>
	<li><a class="leaf" onclick="popwin('11-1')">11-1</a></li>
	<li><a class="leaf" onclick="popwin('11-2')">11-2</a></li>
	<li><a class="leaf" onclick="popwin('11-3')">11-3</a></li>
	<li><a class="leaf" onclick="popwin('11-4')">11-4</a></li>
	<li><a class="leaf" onclick="popwin('11-5')">11-5</a></li>
	<li><a class="leaf" onclick="popwin('11-6')">11-6</a></li>
	<li><a class="leaf" onclick="popwin('11-7')">11-7</a></li>
	<li><a class="leaf" onclick="popwin('11-8')">11-8</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(12)">Chapter 12</a>
	<ul class="leaf_navigation" id="navigation_slide12">
	<li><a class="leaf" onclick="popwin('12-0')">12-0</a></li>
	<li><a class="leaf" onclick="popwin('12-1')">12-1</a></li>
	<li><a class="leaf" onclick="popwin('12-2')">12-2</a></li>
	<li><a class="leaf" onclick="popwin('12-3')">12-3</a></li>
	<li><a class="leaf" onclick="popwin('12-4')">12-4</a></li>
	<li><a class="leaf" onclick="popwin('12-5')">12-5</a></li>
	<li><a class="leaf" onclick="popwin('12-6')">12-6</a></li>
	<li><a class="leaf" onclick="popwin('12-7')">12-7</a></li>
	<li><a class="leaf" onclick="popwin('12-8')">12-8</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(13)">Chapter 13</a>
	<ul class="leaf_navigation" id="navigation_slide13">
	<li><a class="leaf" onclick="popwin('13-0')">13-0</a></li>
	<li><a class="leaf" onclick="popwin('13-1')">13-1</a></li>
	<li><a class="leaf" onclick="popwin('13-2')">13-2</a></li>
	<li><a class="leaf" onclick="popwin('13-3')">13-3</a></li>
	<li><a class="leaf" onclick="popwin('13-4')">13-4</a></li>
	<li><a class="leaf" onclick="popwin('13-5')">13-5</a></li>
	<li><a class="leaf" onclick="popwin('13-6')">13-6</a></li>
	<li><a class="leaf" onclick="popwin('13-7')">13-7</a></li>
	<li><a class="leaf" onclick="popwin('13-8')">13-8</a></li>
	<li><a class="leaf" onclick="popwin('13-9')">13-9</a></li>
	<li><a class="leaf" onclick="popwin('13-10')">13-10</a></li>
	<li><a class="leaf" onclick="popwin('13-11')">13-11</a></li>
	<li><a class="leaf" onclick="popwin('13-12')">13-12</a></li>
	<li><a class="leaf" onclick="popwin('13-13')">13-13</a></li>
	<li><a class="leaf" onclick="popwin('13-14')">13-14</a></li>
	<li><a class="leaf" onclick="popwin('13-15')">13-15</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(14)">Chapter 14</a>
	<ul class="leaf_navigation" id="navigation_slide14">
	<li><a class="leaf" onclick="popwin('14-0')">14-0</a></li>
	<li><a class="leaf" onclick="popwin('14-1')">14-1</a></li>
	<li><a class="leaf" onclick="popwin('14-2')">14-2</a></li>
	<li><a class="leaf" onclick="popwin('14-3')">14-3</a></li>
	<li><a class="leaf" onclick="popwin('14-4')">14-4</a></li>
	<li><a class="leaf" onclick="popwin('14-5')">14-5</a></li>
	<li><a class="leaf" onclick="popwin('14-6')">14-6</a></li>
	<li><a class="leaf" onclick="popwin('14-7')">14-7</a></li>
	<li><a class="leaf" onclick="popwin('14-8')">14-8</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(15)">Chapter 15</a>
	<ul class="leaf_navigation" id="navigation_slide15">
	<li><a class="leaf" onclick="popwin('15-0')">15-0</a></li>
	<li><a class="leaf" onclick="popwin('15-1')">15-1</a></li>
	<li><a class="leaf" onclick="popwin('15-2')">15-2</a></li>
	<li><a class="leaf" onclick="popwin('15-3')">15-3</a></li>
	<li><a class="leaf" onclick="popwin('15-4')">15-4</a></li>
	<li><a class="leaf" onclick="popwin('15-5')">15-5</a></li>
	<li><a class="leaf" onclick="popwin('15-6')">15-6</a></li>
	<li><a class="leaf" onclick="popwin('15-7')">15-7</a></li>
	<li><a class="leaf" onclick="popwin('15-8')">15-8</a></li>
	<li><a class="leaf" onclick="popwin('15-9')">15-9</a></li>
	<li><a class="leaf" onclick="popwin('15-10')">15-10</a></li>
	<li><a class="leaf" onclick="popwin('15-11')">15-11</a></li>
	<li><a class="leaf" onclick="popwin('15-12')">15-12</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(16)">Chapter 16</a>
	<ul class="leaf_navigation" id="navigation_slide16">
	<li><a class="leaf" onclick="popwin('16-0')">16-0</a></li>
	<li><a class="leaf" onclick="popwin('16-1')">16-1</a></li>
	<li><a class="leaf" onclick="popwin('16-2')">16-2</a></li>
	<li><a class="leaf" onclick="popwin('16-3')">16-3</a></li>
	<li><a class="leaf" onclick="popwin('16-4')">16-4</a></li>
	<li><a class="leaf" onclick="popwin('16-5')">16-5</a></li>
	<li><a class="leaf" onclick="popwin('16-6')">16-6</a></li>
	<li><a class="leaf" onclick="popwin('16-7')">16-7</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(17)">Chapter 17</a>
	<ul class="leaf_navigation" id="navigation_slide17">
	<li><a class="leaf" onclick="popwin('17-0')">17-0</a></li>
	<li><a class="leaf" onclick="popwin('17-1')">17-1</a></li>
	<li><a class="leaf" onclick="popwin('17-2')">17-2</a></li>
	<li><a class="leaf" onclick="popwin('17-3')">17-3</a></li>
	</ul>
	</li>
	<li class="">
	<a class="head" onclick="popwin(18)">Chapter 18</a>
	<ul class="leaf_navigation" id="navigation_slide18">
	<li><a class="leaf" onclick="popwin('18-0')">18-0</a></li>
	<li><a class="leaf" onclick="popwin('18-1')">18-1</a></li>
	</ul>
	</li>
	</ul>
	
</div>

<div id="trans" class="sidepage" style="float:right;block:none;">
<?php
/** If play summary, show the transcription of the summary
  * else, show all transcription.
*/
$fpr = fopen($current."trs/$lecture/".$chapter.'.trans', 'r');
if($playSummary){
	$fps = fopen($current."summary/$lecture/".$chapter.'.xml', 'r');
	$data = fread($fps, 4096);
	fclose($fps);
	$xml = xml2array($data);
}
if($fpr){
	$counter = 0;
	while (!feof($fpr)) {
		$buffer = trim(fgets($fpr, 4096));
		$counter ++;
		if($playSummary && isset($sentence[$counter]))
			echo '<p>'.$buffer.'</p>';
		else if(!$playSummary)
			echo '<p>'.$buffer.'</p>';
	}
	fclose($fpr);
}
?>
</div>

</div>
</div>

</body>
</html>
