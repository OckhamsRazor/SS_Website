<?
include_once("../../config.php");
for($i = 7; $i < 18; $i++) {
	$j = 1;
	$wpr = fopen($current."trs/DSP/$i.trans", 'w');
	while(file_exists($current."trs/DSP/$i-$j.trans"))
	{
		$fpr = fopen($current."trs/DSP/$i-$j.trans", 'r');
		while (!feof($fpr)) {	
			$buffer = fgets($fpr);
			fwrite($wpr, $buffer);
		}
		fclose($fpr);
		$j++;
	}
}
fclose($wpr);
?>
