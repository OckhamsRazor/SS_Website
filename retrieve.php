<?php
function chinese_only($arg_strContent) {
	$blnChineseOnly= true;
	$intLoopCount = 0;
	$intContentLength = strlen($arg_strContent);
	while ($intLoopCount < $intContentLength) {
		$chrSingle = substr($arg_strContent,$intLoopCount,1);    
		if(ord($chrSingle) > 0x80) {    
			$chrSingle = substr($arg_strContent,$intLoopCount,2);            
			$intLoopCount++;    
			if(!isBig5($chrSingle)) {
				$blnChineseOnly = false;
				break;
			}            
		}
		else {
			$blnChineseOnly = false;
			break;
		}
		$intLoopCount++;

	}      
	return !$blnChineseOnly;
}
function isBig5($char="") {
	$bc  = hexdec(bin2hex($char));
	if(($bc>=0xa440 && $bc<= 0xc67e)||($bc>=0xc940 && $bc<= 0xf9dc)) {
		return true;
	}
	else {
		return false;
	}
}

function Retrieve($query){
	/* if query is English, to upper class; if Chinese, to UTF-8. */
	if (mb_strlen($query,"Big5") == strlen($query))
		$query = strtoupper($query);
	$chinese_count = 0;
	for ($i = 0; $i < mb_strlen($query, "Big5")+$chinese_count; $i++) {
		$testcase = $query[$i+$chinese_count];
		if (ctype_alnum($testcase) || $testcase == ' ') {
			continue;
		} else {
			$pre_string = mb_substr($query, 0, $i, "Big5");
			$post_string = substr($query, strlen($pre_string));
			$query = "$pre_string $post_string";
			$i += 2;
			$chinese_count ++;
		}
	}
	$query_list = split(' ', $query);
	for($i = 0; $i < count($query_list); $i++)
		if(ctype_alnum($query_list[$i])) $query_list[$i] = strtoupper($query_list[$i]);
	$query = join(' ', $query_list);
	$query = "./Retrieve $query";
	$query = iconv("big5","UTF-8",$query);
	exec($query, $output);

	for($i = 500; !empty($output[$i]); $i++) unset($output[$i]);
	return $output;
}

//$t = Retrieve('language model');
//print_r($t);

?>
