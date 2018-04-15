<?php
include(__DIR__ . '/../../../includes/courses/functions.php');
include(__DIR__ . '/../../../includes/secure_login/db_connect.php');
include(__DIR__ . '/../../../includes/secure_login/functions.php');
//include_once 'includes/courses/functions.php';
//include_once 'includes/secure_login/db_connect.php';
//include_once 'includes/secure_login/functions.php';

ini_set('display_errors', true);
error_reporting(E_ALL);

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
			$course = explode("_",$_POST['courseNum']);
			$courseNum = $course[0];
			$courseName = htmlentities($course[1]);
			upload($courseNum, $courseName, ($_POST['type']), $mysqli);
			break;
		case 'remove':
			remove();
			break;
		case 'search':
			searchCourse();
			break;
		// search files cases //	
		case 'searchLecture':
			$type = 'lectures';
			$path = ($_POST['lectures']);
			searchFileByPath($path);
			break;
		case 'searchTutorial':
			$type = 'tutorials';
			$path = ($_POST['tutorials']);
			searchFileByPath($path);;
			break;
		case 'searchHomework':
			$type = 'homework';
			$path = ($_POST['homework']);
			searchFileByPath($path);
			break;
		case 'searchSummaries':
			$type = 'summaries';
			$path = ($_POST['summaries']);
			searchFileByPath($path);
			break;
		case 'searchExams':
			$type = 'exams';
			$path = ($_POST['exams']);
			searchFileByPath($path);
			break;
		case 'searchByPath':
			searchFileByPath($_POST['path']);
			break;
		// end search files cases //
		
		// voting and points //
		case 'upvoteFile':
			$num = ($_POST['courseNum']);
			$type = ($_POST['type']);
			$ID = ($_POST['fileId']);
			doUpvote($num, $type, $ID, $mysqli);
			break;
		case 'downvoteFile':
			$num = ($_POST['courseNum']);
			$type = ($_POST['type']);
			$ID = ($_POST['fileId']);
			doDownvote($num, $type, $ID, $mysqli);
			break;
		case 'addPointToUser':
			$ADDED_BY_EMAIL = ($_POST['ADDED_BY_EMAIL']);
			addPointToUser($ADDED_BY_EMAIL, $mysqli);
			break;
		case 'removePointToUser':
			$ADDED_BY_EMAIL = ($_POST['ADDED_BY_EMAIL']);
			removePointToUser($ADDED_BY_EMAIL, $mysqli);
			break;
		// end of voting and points //
		
    }
}

// Create course functions
function create() {
	$faculty = ($_POST['faculty']);
	$courseNum = ($_POST['courseNum']);
	$courseName = htmlentities(($_POST["courseName"]));
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
        $success = mkdir("$dataPath/homework", 0755, true);
        $success = mkdir("$dataPath/exams", 0755, true);
        if($success) {
            echo "course creation success" . "<br>";
        } else {
            echo "course creation failure" . $success ."<br>";
            exit;
        }
		
        $myfile = fopen("$dataPath/course_info.php", "w");
    	chmod("$dataPath/course_info.php", 0755);
    	chown("$dataPath/course_info.php", "www-data");
        $txt = '<?php
	define("COURSE_NUM", "' . ($_POST['courseNum']) . '");
	define("COURSE_NAME", "' . $courseName . '");
?>';
        fwrite($myfile, $txt);
        fclose($myfile);
	echo "inserting to DB";
		$success = insert_to_courses_DB($faculty, $courseNum, $courseName);
		echo "course inserted with ret = ";
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
    chmod($path . "/" . $_POST['courseNum']. ".php", 0755);
    chown($path . "/" . $_POST['courseNum']. ".php", "www-data");
    fwrite($myfile, $course_page);
    fclose($myfile);
}

function create_new_psl_config($path) {
    $myfile = fopen($path . "/psl-config.php", "w");
    chmod($path . "/psl-config.php", 0755);
    chown($path . "/psl-config.php", "www-data");
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
    	chmod($path . "/db_connect.php", 0755);
    	chown($path . "/db_connect.php", "www-data");
	fwrite($myfile,
					"<?php
	include_once 'psl-config.php';   // As functions.php is not included
	\$my_course_sqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
?>");
}

function create_new_file_html($target_dir, $file_name) {
    $file_page = file_get_contents('../../data/courses/formats/types/file/fileViewerNew.php', FILE_USE_INCLUDE_PATH);
    $myfile = fopen($target_dir . $file_name . ".php", "w");
    chmod($target_dir . $file_name . ".php", 0755);
    chown($target_dir . $file_name . ".php", "www-data");
    fwrite($myfile, $file_page);
    fclose($myfile);
}

///////// file upload //////////////////////

function upload($courseNum, $courseName, $type, $mysqli) {
	$file_name = htmlentities(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME));
	$file_dir = "data/courses/" . $courseNum . "/" . $type . "/" . $file_name . "/";
	$file_path = $file_dir . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "../../data/courses/" . $courseNum . "/" . $type . "/" . $file_name . "/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$faculty = $_POST['faculty'];
	$week_num = $_POST[$type . 'Num'];
	$name = $_POST[$type . 'Name'];
	$ADDED_BY_ID = $_POST['id'];
	$ADDED_BY_EMAIL = $_POST['username']; //Note: This is actually username
	$path = $target_dir . $file_name . ".php";
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
	
	echo "<br>" . $target_dir . "<br>";
	
	$success = mkdir($target_dir , 0755, true);
	if(!$success) {
		die_nicely("failed to create directory for file");
	}
	
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$id = insert_lecture_to_DB($type, $courseNum, $week_num, $name, $ADDED_BY_ID, $ADDED_BY_EMAIL, $path,
					$pos_votes, $neg_votes, $tot_votes, $year, $semester);	
		
		addPointToUser($ADDED_BY_EMAIL, $mysqli);
		
		$myfile = fopen("$target_dir/file_info.php", "w");
    		chmod("$target_dir/file_info.php", 0755);
    		chown("$target_dir/file_info.php", "www-data");
        $txt = '<?php
		define("FILE_DIR", "' . $file_dir . '");
		define("FILE_PATH", "' . $file_path . '");
		define("FILE", "' .basename($_FILES["fileToUpload"]["name"]) . '");
		define("FILE_NAME", "' . $file_name . '");
		define("FILE_TYPE", "' . $type . '");
		define("FILE_ID", "' . $ID . '");
		define("ADDED_BY_USERNAME", "' . $ADDED_BY_EMAIL . '");
		define("WEEK_NUM", "' . $week_num . '");
		define("COURSE_NUM", "' . $courseNum . '");
		define("COURSE_NAME", "' . $courseName . '");
		define("SEMESTER", "' . $semester . '");
		define("YEAR", "' . $year . '");
?>';
        fwrite($myfile, $txt);
        fclose($myfile);
					
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

function searchCourse () {
	$dataPath ="../../data/courses/" . ($_POST['courseNum']);
	header("Location: ". $dataPath . "/". $_POST['courseNum']. ".php");
}

function searchFile ($courseNum, $file_name, $type) {
	$dataPath ="../../data/courses/" . $courseNum;
	header("Location: ". $dataPath . "/". $type . "/" . $file_name . "/" . $file_name . ".php");
}

function searchFileByPath ($path) {
	header("Location: ". $path);
}

function doUpvote($num, $type, $ID, $mysqli) {
	upvoteFile($num, $type, $ID);
}

function doDownvote($num, $type, $ID, $mysqli) {
	downvoteFile($num, $type, $ID);
}
?>
