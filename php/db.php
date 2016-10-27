<?php
// query for mysql
function mysql_queryf($string)
{
	$args = func_get_args();
	array_shift($args);
	$len = strlen($string);
	$sql_query = "";
	$args_i = 0;
	for($i = 0; $i < $len; $i++)
	{
		if($string[$i] == "%")
		{
			$char = $string[$i + 1];
			$i++;
			switch($char)
			{
				case "%":
					$sql_query .= $char;
				break;
				case "u":
					$sql_query .= "'" . intval(@$args[$args_i]) . "'";
				break;
				case "s":
					$sql_query .= "'" . mysql_real_escape_string(@$args[$args_i]) . "'";
				break;
				case "x":
					$sql_query .= "'" . dechex(@$args[$args_i]) . "'";
				break;
			}
			if($char != "x")
			{
				$args_i++;
			}
		}
		else
		{
			$sql_query .= $string[$i];
		}
	}
	return mysql_query($sql_query);
}

$link = mysql_connect('localhost', 'lecture_system', 'lecture_sql');
// die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
mysql_select_db("lecture");
//$lecture = mysql_queryf("select * from lecture");
//$result = mysql_query("select * from lecture");
//while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
//    print_r($row);
//};

//mysql_close($link);

?>
