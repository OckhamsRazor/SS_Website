<?php
include_once("db.php");
include_once("calTime.php");
@$slide = $_REQUEST['slide'];
mysql_select_db('lecture');
$ch_slides = 0;
$result = mysql_query("select * from lecture where lecture = '$slide'");
$ch_info = mysql_fetch_array($result, MYSQL_BOTH);
$result = mysql_query("select count(*) as count from lecture where chapter_no = (select chapter_no from lecture where lecture = '$slide');");
$row = mysql_fetch_array($result, MYSQL_BOTH);
@$ch_slides = $row['count'];
$result = mysql_query("select * from slidetime where lecture='$slide'");
$slide_progress = mysql_fetch_array($result, MYSQL_BOTH);
@$result = mysql_query("select * from slidetime where lecture='".$ch_info['chapter_no']."'");
$ch_progress = mysql_fetch_array($result, MYSQL_BOTH);
$result = mysql_query("select * from slidetime where lecture='all'");
$row = mysql_fetch_array($result, MYSQL_BOTH);
@$alltime = $row['segtime'];
?>
<html>
<head>
<link rel='stylesheet' href='style.css' type='text/css' media='screen' charset='utf-8'>
<script src='slide.js' type='text/javascript'></script>
<script type='text/javascript'>
var chapter = '<?php echo $slide;?>';
var lecture = 'DSP';
var firstSlide = 0;
var maxSlides = <?php echo $ch_slides?>;
function openFrame(href){
	if(parent.popwin != null)
		parent.popwin.close();
	parent.popwin = window.open (href,
	lecture+"--"+chapter,
	"status=yes,location=no,menubar=no,width=900,height=350");
}
function showkeyterm(key){
	document.getElementById("keyterminfo").style.display = "block";
	if (document.documentElement && document.documentElement.scrollTop)
		document.documentElement.scrollTop = document.documentElement.scrollHeight;
	else if (document.body)
		document.body.scrollTop = document.body.scrollHeight; 
	document.getElementById("keyterminfo2").src = "keyterm.php?keyterm="+key;
}
</script>
</head>
<body onload="init()">
<h1><?php echo @$ch_info['lecture']." ".@$ch_info['title_en'];?></h1>
<div id='info'>
<ul>
<li>Length: <p><?php echo @$ch_info['lecture_len'];?><p></li>
<li>Time Span of This Chapter: <script>display ('element1',<?php echo @$ch_progress['segtime'].','.@$ch_progress['until_time'].','.$alltime;?>);</script><div class='pstart'>Ch 1</div><div class='pend'>Ch 18</div></li>
<li>Time Span of This Slide: <script>display ('element2',<?php echo @$slide_progress['segtime'].','.@$slide_progress['until_time'].','.@$ch_progress['segtime'];?>);</script><div class='pstart'><?php echo @$ch_info['chapter_no']."-1";?></div><div class='pend'><?php echo @$ch_info['chapter_no']."-$ch_slides";?></div></li>
</ul>
<BR>
<div class='btn' id='playSummary'><a onclick="openFrame('../newform.php?chapter=<?php echo $slide;?>&lecture=DSP&summary=true');">Play Summary<BR>(<?php echo sec2time(time2sec(@$ch_info['lecture_len']) * 0.1); ?>)</a></div>
<div class='btn' id='playAll'><a onclick="openFrame('../newform.php?chapter=<?php echo $slide;?>&lecture=DSP');">Play Slide</a></div>
<h5>Key Terms:</h5>
<div id='keytermbrowser'>
<div id='keytermcontainer'>
<?php
$result = mysql_query("select keyterms from chapter2key where lid = ".@$ch_info['lid']);
$row = mysql_fetch_array($result);
$keywords = split(',', @$row['keyterms']);
for($i = 0; !empty($keywords[$i]); $i++){
	$result = mysql_query("select keyterms from kid2keyterms K inner join keyterm T on K.kid = T.kid where T.keyname='".$keywords[$i]."'");
	$row = mysql_fetch_array($result);
	$keyterms = split(',', @$row['keyterms']);
	echo '<div style="float:left;">';
	//echo "<div class='keyword'>\n";
	echo '<div class="onekeyword">';
	echo "<a onclick='showkeyterm(\"$keywords[$i]\")' name='".str_replace(' ', '_', $keywords[$i])."'>".$keywords[$i]."</a>";
	echo '</div>';
	echo "<div class='keyword'>\n";
	for($j = 0; !empty($keyterms[$j]);$j++){
		echo "<a href='#".str_replace(' ', '_', $keyterms[$j])."' onclick='showkeyterm(\"".$keyterms[$j]."\")'>".$keyterms[$j]."</a>";
		if($j > 3) break;
	}
	echo "</div></div>\n";
}
?>
</div>
</div>
<div id="keytermhead">
<!--R<BR>e<BR>l<BR>a<BR>t<BR>e<BR>d<BR><BR>K<BR>e<BR>y<BR>t<BR>e<BR>r<BR>m<BR>-->
<img src='rel.png'></img>
</div>
</div>
<div id='slidebrowser'>
<img id='shower' src='../slides/DSP/<?php echo $slide;?>.jpg'></img>
<div id='slideContainer'>
<img class='arrow' id="lArrow" src='arrow_l.png'></img>
<?php
for($i = 0; $i <= $ch_slides; $i++)
	echo "<img class='slide' src='../slides/DSP/".@$ch_info['chapter_no']."-$i.jpg'></img>";
?>
<img class='arrow' id='rArrow' src='arrow_r.png'></img>
</div>
</div>
<div id="keyterminfo">
<iframe id="keyterminfo2" width=100% height=100% frameborder=0></iframe>
</div>
</body>
</html>
