<?php
include_once("php/db.php");
include_once("index_file/calTime.php");
include_once("retrieve.php");
@$request = $_POST['query'];
$result = Retrieve($request);
//print_r($result);
$expand_no = 2;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5" />
<title>NTU Virtaul Instructor -- Digital Speech Processing</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
<style>
a {cursor: pointer;}
h1 {
	color: white;
	float: left;
	display: block;
	clear: none;
	margin-left: 1em;
	font: oblique small-caps bold 2.2em Arial, sans-serif;
}
a {text-decoration: none;}
#retrieve {
	margin-top: 33px;
	margin-right: 57px;
	float: right;
	clear: none;
	display: block;
}
#container {
	clear: left;
	background: white;
	width: 90%;
	overflow-x: hidden;
	overflow-y: auto;
	padding-left: 30px;
	height: 88%;
	margin: 10px 40px;
}
#container li{
	vertical-align: top;
	font: normal normal normal 1.7em 標楷體;
}
#container li a{
	font: italic normal normal 1em Arial;
	text-decoration: none;
}
#container li a:hover {
        font: italic normal normal 1em Time New Roman;
	text-decoration: underline;
	background-color: #AFD6FF;
}
#container li p{
	line-height: 3px;
	margin: 0;
	text-indent: 1em;
	margin-bottom: 15px;
        font: normal normal normal 0.9em Time New Roman;
}
#term {
	font: normal small-caps normal 1.6em Time New Roman;
}
.progress_timeifo {
	margin-top: 0px;
}
#keyterminfo{
	background: white;
	border: 3px solid gray;
	position: absolute;
	width: 89%;
	height: 200px;
	z-index: 4;
	left: 47px;
	top: 760px;
	display: none;
}
iframe {
	width: 95%;
	float: left;
	clear: none;
}
#close_tab {
	background: red;
	font-size: 2em;
	float: left;
	border: 2px outset gray;
	cursor: pointer;
}
</style>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var chapter = '';
var lecture = 'DSP';
var popwin = null;
var pop = null;
var pop2 = null;
var isfocus = false;
$(document).ready(function(){
	$(window).keypress(function(e){ /*Bind KeyPress Event Handeler*/
		if(isfocus) return;
		var txt = String.fromCharCode(e.which);
		if (e.which == 32 || (65 <= e.which && e.which <= 65 + 25)
		                        || (97 <= e.which && e.which <= 97 + 25)) {
			$('#query').val(txt);
			$('#query').focus();
			isfocus = true;
		}
	});
	$('#query').focus(function(){
		isfocus = true;
	});
	$('#query').blur(function(){
		isfocus = false;
	});
	$('.play').click(function(){
		var chap = $(this).attr('chapter');
		var start = $(this).attr('start');
		var href = "newform.php?lecture=DSP&chapter="+chap+"&start="+start;
		if(pop != null)
			pop.close();
		pop = window.open(href,'NTU Virtual Instructor',"status=yes,location=no,menubar=no,width=900,height=350");
	});
	$('#close_tab').click(function(){
		$('#keyterminfo').hide();
	});
	});
function showterm(obj){ 
		$('#keyterminfo').show();
		$('#keyterminfo').css('top', $(window).height() - 200);
		$("#keyterminfo2").attr('src', "index_file/keyterm.php?keyterm="+obj.text);
}
/*Function For Progress Bar*/
function display (id, segtime, untiltime, alltime){
	untiltime = untiltime - segtime;
	var imagesize = 300;
	var modify = 1;
	var currWidth = (segtime/alltime) * (imagesize) + modify;
	var untilWidth = (untiltime/alltime) * (imagesize) - modify;
	var allhr = Math.floor(alltime / 3600);
	var allmin = Math.floor(alltime / 60) % 60;
	if(allmin < 10) allmin = '0'+allmin;
	var allsec = Math.round((alltime % 60) * 100) / 100;
	if(allsec < 10) allsec = '0'+allsec;
	segtime = Math.round(segtime * 100) / 100;
	document.write('<div class=\'progress\' id=\''+id+'\'>');
	document.write('<div class=\'progress_out\' style="width:'+untilWidth+'px"></div>');
	document.write('<div class=\'progress_in\' style="width:'+currWidth+'px"></div>');
	document.write('</div>');
	document.write('<div class\'progress_timeifo\'>'+segtime+' sec. in '+allhr+':'+allmin+':'+allsec+'</div>');
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
<body>
<a href="index.php"><h1>NTU Virtual Instructor</h1> </a>
<div id="retrieve"><form method='POST' action="<?php echo @$_SERVER['PHP_SELF'];?>" id="search_form">
<font color='white'>Lecture Search: </font>


<!--<input id="query" type='text' size='12' maxlength='100' name='query'></input>-->

<!-- <select name='query' id="query" >
<option value="black word algorithm"> black word algorithm</option>
<option value="frequencies"> frequencies</option>
</select> -->

<input id='query' type="text" name='query' placeholder="Search by speech" lang='zh-TW' speech x-webkit-speech onwebkitspeechchange='document.getElementById("search_form").submit.click()' onspeechchange='document.getElementById("search_form").submit.click()'>

<input type="submit" value="SEARCH" name="submit">
</form>
</div>
<div id="container">
<?php echo "<p id='term'>About ".count($result)." Results For Term <b>\"$request\"</b></p>";?>
<ol>
<?php
function exploringResult($arr) { /*Add previous key value*/
	$explore = array();
	$keypool = '';
	for($i = 0; $i < count($arr); $i++){
		list($k, $v) = sscanf($arr[$i], "%s%s");
		$sentence_time = substr($k, 0, 10);
		$sentence_serial = substr($k, 11);
		$k1 = sprintf("%s-%06d", $sentence_time, $sentence_serial+10); 
		@$explore[$k] = $v;
		if($i != count($arr) - 1) $keypool .= "'$k', '$k1',";
		else $keypool .= "'$k', '$k1'";
	}
	$retrieve = mysql_query("select S.sentence_id, S.sentence, S.chapter_no, S.lecture_len,KR.keyterms,S.title_en,S.segtime,S.playtime,S.untiltime from (select C.*, L.lid, L.title_en,L.lecture_len from sentence2chapter C left join lecture L on C.chapter_no = L.lecture where C.sentence_id in ($keypool)) S left join (select group_concat(K.keyname) keyterms, R.lid from K_L_Relation R left join keyterm K on R.kid = K.kid group by R.lid) KR on KR.lid = S.lid");
	while($row = mysql_fetch_array($retrieve)){
		@$explore[$row['sentence_id']] = $row['sentence']." ; ".$row['chapter_no']." ; ".$row['keyterms']." ; ".$row['lecture_len']." ; ".$row['title_en']." ; ".$row['segtime']." ; ".$row['playtime']." ; ".$row['untiltime'];
	}
	return $explore;
}
function expandSentence($arr, $id){
	/*If the sentence is too short, add the previous sentence*/
	@$split = split(';', $arr[$id]);
	if(strlen($split[0]) > 20)
		return $split[0];
	$new_sentence = $split[0];
	$sentence_time = substr($id, 0, 10);
	$sentence_serial = substr($id, 11);
	$new_id = sprintf("%s-%06d",$sentence_time,$sentence_serial+10);
	@$split = split(';', $arr[$new_id]);
	$new_sentence .= $split[0];
	return $new_sentence;
}
if(!isset($_POST["submit"]))
	echo "<font color=red>No Query!!!</font>\n";
else if(empty($result))
	echo "<font color=red>$request is not found!!</font>\n";
else {
        //print_r($result);
	$explore = exploringResult($result);
	foreach($result as $k=>$output){
		$output = split(" ", $output);
		$v = $explore[$output[0]];
		$terms = split(";", $v);
                //print_r($terms);
//		$sentence = $terms[0];
		$sentence = expandSentence($explore, $output[0]);
		$slide_time = time2sec($terms[3]);
		$keyterm = array();
		$i = 0;
		if(!empty($terms[2])){
			$keyterms = split(',', $terms[2]);
			foreach($keyterms as $key=>$value){
				if(strstr($sentence, $value)){
					str_replace($value, "<font color=red>$value</font>", $sentence);
//					unset($keyterms[$key]);
				}
			}
		}
		$id = md5($sentence);
		$terms[1] = trim($terms[1]);
		$untiltime = $terms[7];
		$playtime = $terms[6];
		$segtime = $terms[5];
		echo "<li><script>display('$id',$segtime,$untiltime,$slide_time)</script> in ".'<a title="'.$output[0].' '.$output[1].'" href="index.php?slide='.$terms[1].'">'.$terms[1]." ".$terms[4]."</a><BR><a class='play' chapter='".$terms[1]."' start='$playtime'>Play</a><font size='4'><i>(Transcription: ... $sentence ...)</i></font><p>Key Terms Related To This Slide: <a class='term' onclick='showterm(this)'>".join("</a>,<a class='term' onclick='showterm(this)'>", $keyterms).'</a></li>';
	}
}
mysql_close($link);
?>
</ol>
</div>
<div id="keyterminfo">
<iframe id="keyterminfo2" width=98% height=100% frameborder=0></iframe><div id="close_tab">X</div>
</div>
</body>
</html>
