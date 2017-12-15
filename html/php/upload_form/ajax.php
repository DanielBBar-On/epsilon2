<?php

var_dump($_POST);

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'insert':
            insert();
            break;
        case 'create':
            create();
            break;
    }
}

function create() {
    echo "The select function is called." . "<\br>";
	$path ="../../../data/courses/" . ($_POST['courseNum']);
	echo $path;
	if (!is_dir($path)) {
        $success = FALSE;
		$success = mkdir($path, 0755, true);
        $success = mkdir("$path/lectures", 0755, true);
        $success = mkdir("$path/tutorials", 0755, true);
        $success = mkdir("$path/hw", 0755, true);
        $success = mkdir("$path/past_exams", 0755, true);
        if($success) {
            echo "course creation success" . "<\br>";
        } else {
            echo "course creation failure" . "<\br>";
            exit;
        }

        $myfile = fopen("$path/course_info.txt", "w");
        $txt = "<?php\n" .
                "define(\"COURSE_NUM\", " . ($_POST['courseNum']) . ");\n" .
                "define(\"COURSE_NAME\", " . ($_POST['courseName']) . ");\n" .
                "?>";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    exit;
}

function insert() {
    echo "The insert function is called.";
    exit;
}
?>