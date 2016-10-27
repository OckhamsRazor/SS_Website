<?php
include_once('calTime.php');
include_once('db.php');
function cmp($a, $b)
{
	$as = split($a, '-');
	$bs = split($b, '-');
	$na = 100*$as[0] + $as[1];
	$nb = 100*$bs[0] + $bs[1];
	if ($na == $nb) {
		return 0;
	}
	return ($na < $nb) ? -1 : 1;
}
mysql_select_db('lecture');
mysql_query("delete from slidetime");
$time = array();
for($i = 1; $i <= 18; $i ++){
//mysql_query("select L.*, group_concat(keyname) keyterms from (select * from lecture where chapter_no = '$i') L left join (select K.keyname, R.lid from keyterm K inner join K_L_Relation R on K.kid = R.kid) O on L.lid = O.lid group by L.lid");
$mysql_result = mysql_query("select * from lecture where chapter_no = '$i'");
$untiltime = 0.0;
while($row = mysql_fetch_array($mysql_result, MYSQL_BOTH)){
	@$time[$row['lecture']] = time2sec(@$row['lecture_len']);
	if(@$time[$row['lecture']] == 0) @$time[$row['lecture']] = 0.001;
}
}
//print_r($time);
 $chapter = 1;
 $slide = 1;
$alltime = 0.0;
for($chapter = 1; $chapter<=18; $chapter++){
 $chaptertime = 0;
 for($slide = 1; !empty($time["$chapter-$slide"]); $slide++){
// 	echo "$chapter-$slide ".$time["$chapter-$slide"]." $chaptertime\n";
	mysql_query("insert into slidetime values('$chapter-$slide',".$time["$chapter-$slide"].", $chaptertime)");
	$chaptertime+=$time["$chapter-$slide"];
 }
 mysql_query("insert into slidetime values('$chapter', $chaptertime, $alltime)");
 $char_time = sec2time($chaptertime);
 mysql_query("update lecture set lecture_len = '$char_time' where lecture='$chapter'");
 $alltime += $chaptertime;
 //echo "$chapter $chaptertime\n";
}
//echo "all $alltime\n";
 mysql_query("insert into slidetime values('all', $alltime, $alltime)");
mysql_close($link);
?>
