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
		case 'upload':
			upload(($_POST['courseNum']), ($_POST['type']));
			break;
		case 'remove':
			remove();
			break;
		case 'search':
			search();
			break;
    }
}

// Create course functions
function create() {
	$faculty = ($_POST['faculty']);
	$courseNum = ($_POST['courseNum']);
	$courseName = ($_POST['courseName']);
	echo "<br>The create function is called.<br><br><br>";
	$dataPath ="../../data/courses/" . ($_POST['courseNum']);
	$includesPath = "../../../includes/courses/" . ($_POST['courseNum']);
	echo $dataPath . "<br>";
	if (!is_dir($dataPath)) {
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
		
		$success = insert_to_courses_DB($faculty, $courseNum, $courseName);
		if (!$success) {
			header("Location: ". $dataPath . "/". $_POST['courseNum']. ".php?error=" . $success);
		}
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

function create_new_file_html($target_dir, $file_name) {
    $file_page = file_get_contents('../../data/courses/formats/file/fileViewerNew.php', FILE_USE_INCLUDE_PATH);
    $myfile = fopen($target_dir . $file_name . ".php", "w");
    fwrite($myfile, $file_page);
    fclose($myfile);
}

function upload($courseNum, $type) {
	$file_name = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
	$file_dir = "data/courses/" . $courseNum . "/" . $type . "/" . $file_name . "/";
	$file_path = $file_dir . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "../../data/courses/" . $courseNum . "/" . $type . "/" . $file_name . "/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$faculty = $_POST['faculty'];
	$num = $_POST['lectureNum'];
	$name = $_POST['lectureName'];
	$ADDED_BY_ID = $_POST['id'];
	$ADDED_BY_EMAIL = '@';
	$path = $target_file;
	$pos_votes = 0;
	$neg_votes = 0;
	$tot_votes = $pos_votes - $neg_votes;
	$year = $_POST['year'];
	$semester =  $_POST['semester'];
	
	// Check if file type
	
	// Limit file size
	
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	
	$success = mkdir($target_dir , 0755, true);
	if(!$success) {
		die_nicely("failed to create directory for file");
	}
	
	$myfile = fopen("$target_dir/file_info.php", "w");
        $txt = '<?php
		define("FILE_DIR", "' . $file_dir . '");
		define("FILE_PATH", "' . $file_path . '");
		define("FILE", "' .basename($_FILES["fileToUpload"]["name"]) . '");
		define("FILE_NAME", "' . $file_name . '");
	define("COURSE_NUM", "' . ($_POST['lectureNum']) . '");
	define("COURSE_NAME", "' . ($_POST['lectureName']) . '");
?>';
        fwrite($myfile, $txt);
        fclose($myfile);
	
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		insert_lecture_to_DB($courseNum, $name, $ADDED_BY_ID, $ADDED_BY_EMAIL, $path,
					$pos_votes, $neg_votes, $tot_votes, $year, $semester);
					
		create_new_file_html($target_dir, $file_name);
		header("Location: ". $target_dir . $file_name . ".php");
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

function remove() {
	$faculty = ($_POST['faculty']);
	$courseNum = ($_POST['courseNum']);
	$courseName = ($_POST['courseName']);
	$dataPath ="../../data/courses/" . ($_POST['courseNum']);
	$includesPath = "../../../includes/courses/" . ($_POST['courseNum']);
	echo $dataPath . "<br>";
	if (is_dir($dataPath)) {
		$success = FALSE;
		$success = deleteDirectory($includesPath);
		$success = deleteDirectory($dataPath);
	}
	
	remove_course_DB($faculty, $courseNum, $courseName);
}

function search () {
	$dataPath ="../../data/courses/" . ($_POST['courseNum']);
	header("Location: ". $dataPath . "/". $_POST['courseNum']. ".php");
}
?>