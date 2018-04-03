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
	$dataPath ="../../data/courses/" . ($_POST['courseNum']);
	$includesPath = "../../../includes/courses/" . ($_POST['courseNum']);
	echo $dataPath . "<br>";
	if (!is_dir($data_path)) {
        $success = FALSE;
		$success = mkdir($includesPath, 0755, true);
		$success = mkdir($dataPath, 0755, true);
        $success = mkdir("$dataPath/lectures", 0755, true);
        $success = mkdir("$dataPath/tutorials", 0755, true);
        $success = mkdir("$dataPath/hw", 0755, true);
        $success = mkdir("$dataPath/past_exams", 0755, true);
        if($success) {
            echo "course creation success" . "<br>";
        } else {
            echo "course creation failure" . "<br>";
            exit;
        }
		
        $myfile = fopen("$dataPath/course_info.php", "w");
        $txt = '<?php
	define("COURSE_NUM", "' . ($_POST['courseNum']) . '");
	define("COURSE_NAME", "' . ($_POST['courseName']) . '");
?>';
        fwrite($myfile, $txt);
        fclose($myfile);
		
		insert_to_courses_DB($faculty, $courseNum, $courseName);
		create_course_DB($faculty, $courseNum, $courseName);
        create_new_course_html($dataPath);
		create_new_psl_config($includesPath);
		create_new_db_connect($includesPath);
        header("Location: ". $dataPath . "/". $_POST['courseNum']. ".php");
    } else {
        header("Location: ". $dataPath . "/" . $_POST['courseNum']. ".php?error=COURSEEXISTS");
	}
    exit;
}

function create_new_course_html($path) {
    $course_page = file_get_contents('../../data/courses/formats/course_page_new.php', FILE_USE_INCLUDE_PATH);
    $myfile = fopen($path . "/" . $_POST['courseNum']. ".php", "w");
    fwrite($myfile, $course_page);
    fclose($myfile);
}

function create_new_psl_config($path) {
    $myfile = fopen($path . "/psl-config.php", "w");
    fwrite($myfile, 
					'<?php
	/**
	 * These are the database login details\n
	 */
	define("HOST", "localhost");     // The host you want to connect to.
	define("USER", "courses");    // The database username.
	define("PASSWORD", "Ab123456");    // The database password.
	define("DATABASE", "' .$_POST['courseNum'] . '");    // The database name.
	define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "member");
 
	define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!\n
?>'

	);
	
    fclose($myfile);
}

function create_new_db_connect($path) {
	$myfile = fopen($path . "/db_connect.php", "w");
	fwrite($myfile,
					"<?php
	include_once 'psl-config.php';   // As functions.php is not included
	\$my_course_sqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
?>");
}
function insert() {
    echo "The insert function is called.<br>";
    exit;
}
?>