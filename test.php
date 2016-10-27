<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title></title></head>
<body>
<?php
$fp=fopen("intl_list.txt","r");
echo '<table>';
while($line=fgets($fp)){
//	preg_grep('\\',$
	//echo $line.'<br />';
	$length=strlen($line);
	$date=substr($line,0,8);
	$title=mb_substr($line,9,$length,'utf-8');
	$title=str_replace("\n","",$title);

	echo '<tr><td width="600"><input type="button" style="text-align:left;width:545px;font-size:14pt;" value="'.$date.' '.$title.'" /></td><td width="40"><input type="button" value="abstract" style="font-size:14pt;"  /></td><td width="40"><input type="button" value="related" style="font-size:14pt;" /></td></tr>'."\n";
}
echo '</table>';
?>
</body>
</html>
