<?php
	$path = ($_POST['path']);
    $fp = fopen($path . '/forum.json', 'w');
	fwrite($fp, var_dump($_POST));
    fwrite($fp, $_POST['myJson']);
    fclose($fp);
?>