<?php
include_once 'includes/courses/functions.php';

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
	$faculty = ($_POST['faculty']);
	$courseNum = ($_POST['courseNum']);
	$courseName = ($_POST['courseName']);
	echo "<br>The create function is called.<br><br><br>";
	$path ="../../data/courses/" . ($_POST['courseNum']);
	echo $path . "<br>";
	if (!is_dir($path)) {
        $success = FALSE;
		$success = mkdir($path, 0755, true);
        $success = mkdir("$path/lectures", 0755, true);
        $success = mkdir("$path/tutorials", 0755, true);
        $success = mkdir("$path/hw", 0755, true);
        $success = mkdir("$path/past_exams", 0755, true);
        if($success) {
            echo "course creation success" . "<br>";
        } else {
            echo "course creation failure" . "<br>";
            exit;
        }

        $myfile = fopen("$path/course_info.txt", "w");
        $txt = "<?php\n" .
                "define(\"COURSE_NUM\", \"" . ($_POST['courseNum']) . "\");\n" .
                "define(\"COURSE_NAME\", \"" . ($_POST['courseName']) . "\");\n" .
                "?>";
        fwrite($myfile, $txt);
        fclose($myfile);

		
		insert_to_courses_DB($faculty, $courseNum, $courseName);
        create_new_course_html($path);
        header("Location: ". $path);
    } else {
        header("Location: ". $path . "/" . $_POST['courseNum']. ".php?error=COURSEEXISTS");
    }

    header("Location: ". $path . "/". $_POST['courseNum']. ".php"); 
    exit;
}

function create_new_course_html($path) {
    $course_defines = file_get_contents("$path/course_info.txt", FILE_USE_INCLUDE_PATH);
    $course_page = file_get_contents('../../Templates/course_page_new.php', FILE_USE_INCLUDE_PATH);
    $myfile = fopen($path . "/" . $_POST['courseNum']. ".php", "w");
    fwrite($myfile, $course_defines);
    fwrite($myfile, $course_page);
    fclose($myfile);
}

function insert() {
    echo "The insert function is called.<br>";
    exit;
}
?>