<?php
$fpr = fopen(__DIR__ . '/sentence2chapter1-3', 'r');

while(!feof($fpr)){
	$str = fgets($fpr);
	$str = split("\t", $str);
	$slide = trim($str[1]);
	if(count($str) == 1) $slide = '2-8';
	$str = trim($str[0]);
	$wpr = fopen(__DIR__ . "/$slide.trans", 'a');
	fwrite($wpr, $str."\n");
	fclose($wpr);
}
fclose($fpr);
?>

