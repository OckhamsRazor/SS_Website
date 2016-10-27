<?php
$link = mysql_connect('localhost', 'lecture_system', 'lecture_sql');
function cmp($a, $b)
{
	$as = split('-', $a);
	$bs = split('-', $b);
	$na = 100 * $as[0] + $as[1];
	$nb = 100 * $bs[0] + $bs[1];
	if ($na == $nb) {
		return 0;
	}
	return ($na < $nb) ? -1 : 1;
}
mysql_select_db('lecture');
$keyterm = @$_REQUEST['keyterm'];
$keyterm = trim($keyterm);
$keyterms = array();
$result = mysql_query("select L.lecture from lecture L inner join (select lid from K_L_Relation KR inner join keyterm K on K.kid = KR.kid where keyname='$keyterm') R on L.lid = R.lid");
$i = 0;
while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	$keyterms[$i++] = @$row['lecture'];
}
usort($keyterms, "cmp");
mysql_close($link);
?>
<html>
<head>
<style>
body{
	width: 500px;
}

p {
	line-height: 1em;
	margin: 0px;
	font: normal normal bold 1.5em Time New Roman;
}
a {
	text-decoration: none;
	color: blue;
	margin-left: 8px;
}
a:hover {
	text-decoration: underline;
	background: #AFD6FF;
	margin-left: 8px;
}
</style>
<script type="text/javascript">
function key_click(obj) {
	var chap = obj.innerHTML;
	parent.parent.location = parent.parent.location.href.substring(0,parent.parent.location.href.lastIndexOf('/')+1)+'index.php?slide='+chap;

}
</script>
</head>
<body>
<p>This key term(<?php echo $keyterm;?>) first appears in <?php echo "<a onclick='key_click(this);'>".$keyterms[0]."</a>";?></p>
<?php
if(count($keyterms) > 1){
echo "<p>Also appears in slide(s):";
for($i = 1; !empty($keyterms[$i]); $i++) 
	echo "<a onclick='key_click(this);'>".$keyterms[$i]."</a>";
//	echo "<a target='_blank' href='../index.php?slide=".$keyterms[$i]."'>".$keyterms[$i]."</a>";
echo "</p>";
}
?>
</body>
</html>
