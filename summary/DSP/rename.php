<?
$dir = __DIR__ . '/' ; 
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if($file == 'rename.php') continue;
			$oldfile = $file;
			$file = split("\.", $file);
			$newfile = '';
			if(count($file) == 2)
				$newfile = $file[0].".xml";
			else if (count($file) == 3)
				$newfile = $file[0].'-'.$file[2].".xml";
			rename("$dir/$oldfile", "$dir/$newfile");
		}
		closedir($dh);
	}
}
?>
