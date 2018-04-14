<?php
	$path = ($_POST['path']);
echo "@@@";
    $fp = fopen($path . '/forum.json', 'w');
	fwrite($fp, var_dump($_POST));
    fwrite($fp, $_POST['myJson']);
    fclose($fp);
?>
