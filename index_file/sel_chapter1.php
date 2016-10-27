<?php
include_once("db.php");
include_once("calTime.php");
$chapter = @$_REQUEST['chapter'];
mysql_select_db('lecture');
$chapter_title = '';
//$sql="select title_en from lecture where lecture='$chapter-0'";
$result = mysql_query("select title_en from lecture where lecture='$chapter-0'");
$row = mysql_fetch_array($result, MYSQL_BOTH);
$chapter_title = @$row['title_en'];
$ch_slides = 0;
$result = mysql_query("select count(*) as count from lecture where chapter_no = '$chapter'");
$row = mysql_fetch_array($result, MYSQL_BOTH);
$ch_slides = @$row['count'] + 1;
$result = mysql_query("select * from slidetime where lecture='".$chapter."'");
$ch_progress = mysql_fetch_array($result, MYSQL_BOTH);
$result = mysql_query("select * from slidetime where lecture='all'");
$row = mysql_fetch_array($result, MYSQL_BOTH);
$alltime = @$row['segtime'];
?>
<html>
<head>
<link rel='stylesheet' href='style.css' type='text/css' media='screen' charset='utf-8'>
<script src='slide.js' type='text/javascript'></script>
<script type='text/javascript'>
var chapter = '<?php echo "$chapter-0";?>';
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
<body onload='init()'>
<h1><?php echo $chapter.' '.$chapter_title;?></h1>
<div id='info'>
<ul>
<li>Length: <p><?php echo sec2time(@$ch_progress['segtime']);?><p></li>
<li>Time Span of This Chapter: <script>display ('element1',<?php echo @$ch_progress['segtime'].','.@$ch_progress['until_time'].','.$alltime;?>);</script><div class='pstart'>Ch 1</div><div class='pend'>Ch 18</div></li>
</ul>
<BR>
<div class='btn' id='playSummary'><a onclick="openFrame('../newform.php?chapter=<?php echo $chapter;?>&lecture=DSP&summary=true');">Play Summary<BR>(<?php echo sec2time(@$ch_progress['segtime'] * 0.1); ?>)</a></div>
<div class='btn' id='playAll'><a onclick="openFrame('../newform.php?chapter=<?php echo $chapter;?>&lecture=DSP');">Play Chapter</a></div>
<h5>Key Terms</h5>
<div id='keytermbrowser'>
<div id='keytermcontainer'>
<?php
//$result = mysql_query("select group_concat(keyname) keyterms from (select * from lecture where chapter_no = '$chapter') L left join (select distinct K.keyname, R.lid from keyterm K inner join K_L_Relation R on K.kid = R.kid) O on L.lid = O.lid group by L.chapter_no;");
//$row = mysql_fetch_array($result);
$fpr = fopen(__DIR__ . '/chapter_list', 'r');
while(!feof($fpr)){
	$ch = trim(fgets($fpr));
	$keywords = trim(fgets($fpr));
	if($ch == $chapter)
		break;
}
$keywords = split(',', $keywords);
$keycount = array();
for($i = 0; !empty($keywords[$i]); $i++){
	if(empty($keycount[$keywords[$i]])) $keycount[$keywords[$i]] = 1;
	else continue;
	$result = mysql_query("select keyterms from kid2keyterms K inner join keyterm T on K.kid = T.kid where T.keyname='".str_replace("'", "\'",$keywords[$i])."'");
	$row = mysql_fetch_array($result);
	$keyterms = split(',', @$row['keyterms']);
	echo "<div class='keyword'>\n";
	echo "<h3><a onclick='showkeyterm(\"".str_replace("'", "\'",$keywords[$i])."\")' name='".str_replace(' ', '_', $keywords[$i])."'>".$keywords[$i]."</a></h3>";
	for($j = 0; !empty($keyterms[$j]);$j++){
		echo "<a href='#".str_replace(' ', '_', trim($keyterms[$j]))."' onclick=\"showkeyterm('".str_replace("'", "\'",$keyterms[$j])."')\">".$keyterms[$j]."</a>";
		if($j > 3) break;
	}
	echo "</div>\n";
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
<img id='shower' src="../slides/DSP/<?php echo $chapter;?>-0.jpg"></img>
<div id='slideContainer'>
<img class='arrow' id="lArrow" src='arrow_l.png'></img>
<?php
for($i = 0; $i < $ch_slides; $i++)
	echo "<img class='slide' src='../slides/DSP/".$chapter."-$i.jpg'></img>";
?>
<img class='arrow' id='rArrow' src='arrow_r.png'></img>
</div>
</div>
<div id="keyterminfo">
<iframe id="keyterminfo2" width=100% height=100% frameborder=0></iframe>
</div>
</body>
</html>
