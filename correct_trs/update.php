<?php
include_once("../php/db.php");
mysql_select_db("lecture");
$fpr = fopen(__DIR__ . "/sentence2slide", "r");
while(!feof($fpr)){
	$str = fgets($fpr);
	if(empty($str)) continue;
	$split = split(';', $str);
	$k = $split[0];
	$ch = $split[1];
	$s = $split[2];
	mysql_query("insert into sentence2chapter values('$k','$ch','$s')");
}
mysql_close($link);
fclose($fpr);
?>
