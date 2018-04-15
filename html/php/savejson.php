<?php
/*	$path = ($_POST['path']);
    $fp = fopen($path . '/forum.json', 'w+');
	chmod($path . '/forum.json', 0755);
	chown($path . '/forum.json', "www-data");
    fwrite($fp, $_POST['myJson']);
    fclose($fp);*/
error_reporting(E_ALL);
ini_set('display_errors',1);

if(isset($_POST['myJson'])) {
ini_set("allow_url_include", "1");
    $json = ($_POST['myJson']);
    clearstatcache();
	 $path = ($_POST['path']);
	touch($path . '/forum.json');
    $fp = fopen($path . '/forum.json', 'w');
    fwrite($fp, $json);
    fclose($fp);
} else {
    echo "Object Not Received";
}
?>
