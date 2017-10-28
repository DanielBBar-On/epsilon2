<?php

var_dump($_POST);

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'insert':
            insert();
            break;
        case 'select':
            select();
            break;
    }
}

function select() {
    echo "\n The select function is called. \n";
	$path ="../../../data/courses/" . ($_POST['courseNum']);
	echo $path;
	if (!is_dir($path)) {
		mkdir($path, 0755, true);
		print_r(error_get_last());
	}
    exit;
}

function insert() {
    echo "The insert function is called.";
    exit;
}
?>
