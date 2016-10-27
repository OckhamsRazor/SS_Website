<?php
function time2sec($time){
	$times = split(':', $time);
	$sec = $times[0] * 3600 + $times[1] * 60 + $times[2];
	return $sec;
}
function sec2time($sec){
	$hr = $sec / 3600;
	$min = ($sec % 3600) / 60;
	$s = fmod($sec, 60.000);
	return sprintf("%d:%02d:%.3f", $hr, $min, $s);
}
?>
