<?php
include_once 'psl-config.php';

function insert_to_courses_DB($faculty, $num, $name) {
	$servername = constant("COURSES_HOST");
	$username = constant("COURSES_USER");
	$password = constant("COURSES_PASSWORD");
	$dbname = constant("COURSES_DATABASE");

	echo "FUNCTION CALLED!" . "<br>";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	/*$sql = "BEGIN
				IF NOT EXISTS (SELECT num FROM courses 
								WHERE num = '$num')
					BEGIN
						INSERT INTO courses (faculty, num, name)
						VALUES ('$faculty', '$num', '$name')
					END
			END";*/
	$sql = "INSERT INTO courses (faculty, num, name)
			VALUES ('$faculty', '$num', '$name')";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}

function create_course_DB($faculty, $num, $name) {
	$servername = constant("COURSES_HOST");
	$username = constant("COURSES_USER");
	$password = constant("COURSES_PASSWORD");
	$dbname = constant("COURSES_DATABASE");

	echo "CREATE COURSE FUNCTION CALLED!" . "<br>";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	//create new DB
	$sql = "CREATE DATABASE `" . $num . "` /*!40100 DEFAULT CHARACTER SET latin1 */";

	if ($conn->query($sql) === TRUE) {
		echo "Course" .$num . " DB created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	//create lectures table
	$sql = "CREATE TABLE `lectures` (
									 `id` int(11) NOT NULL AUTO_INCREMENT,
									 `num` int(11) NOT NULL,
									 `name` text NOT NULL,
									 `ADDED_BY_ID` int(11) NOT NULL,
									 `ADDED_BY_EMAIL` text NOT NULL,
									 `path` text NOT NULL,
									 `pos_votes` int(11) NOT NULL,
									 `neg_votes` int(11) NOT NULL,
									 `tot_votes` int(11) NOT NULL,
									 `year` int(11) NOT NULL,
									 `semester` text NOT NULL,
									 PRIMARY KEY (`id`)
									) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1";
	
	if ($conn->query($sql) === TRUE) {
		echo "lectures table created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

		//create tutorials table
	$sql = "CREATE TABLE `tutorials` (
									 `id` int(11) NOT NULL AUTO_INCREMENT,
									 `num` int(11) NOT NULL,
									 `name` text NOT NULL,
									 `ADDED_BY_ID` int(11) NOT NULL,
									 `ADDED_BY_EMAIL` text NOT NULL,
									 `path` text NOT NULL,
									 `pos_votes` int(11) NOT NULL,
									 `neg_votes` int(11) NOT NULL,
									 `tot_votes` int(11) NOT NULL,
									 `year` int(11) NOT NULL,
									 `semester` text NOT NULL,
									 PRIMARY KEY (`id`)
									) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1";
	
	if ($conn->query($sql) === TRUE) {
		echo "tutorials table created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

		//create homework table
	$sql = "CREATE TABLE `homeowrk` (
									 `id` int(11) NOT NULL AUTO_INCREMENT,
									 `num` int(11) NOT NULL,
									 `name` text NOT NULL,
									 `ADDED_BY_ID` int(11) NOT NULL,
									 `ADDED_BY_EMAIL` text NOT NULL,
									 `path` text NOT NULL,
									 `pos_votes` int(11) NOT NULL,
									 `neg_votes` int(11) NOT NULL,
									 `tot_votes` int(11) NOT NULL,
									 `year` int(11) NOT NULL,
									 `semester` text NOT NULL,
									 PRIMARY KEY (`id`)
									) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1";
	
	if ($conn->query($sql) === TRUE) {
		echo "homework table created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

		//create summaries table
	$sql = "CREATE TABLE `summaries` (
									 `id` int(11) NOT NULL AUTO_INCREMENT,
									 `num` int(11) NOT NULL,
									 `name` text NOT NULL,
									 `ADDED_BY_ID` int(11) NOT NULL,
									 `ADDED_BY_EMAIL` text NOT NULL,
									 `path` text NOT NULL,
									 `pos_votes` int(11) NOT NULL,
									 `neg_votes` int(11) NOT NULL,
									 `tot_votes` int(11) NOT NULL,
									 `year` int(11) NOT NULL,
									 `semester` text NOT NULL,
									 PRIMARY KEY (`id`)
									) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1";
	if ($conn->query($sql) === TRUE) {
		echo "summaries table created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	//create exams table
	$sql = "CREATE TABLE `exams` ( `id` int(11) NOT NULL AUTO_INCREMENT, `num` int(11) NOT NULL, `name` text NOT NULL, `ADDED_BY_ID` int(11) NOT NULL, `ADDED_BY_EMAIL` text NOT NULL, `path` text not NULL, `pos_votes` int(11) NOT NULL, `neg_votes` int(11) NOT NULL, `tot_votes` int(11) NOT NULL, `year` int(11) NOT NULL, `semester` int(11) NOT NULL, `moed` int(2) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1";

	if ($conn->query($sql) === TRUE) {
		echo "exams table created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}


/**
 * @param string $name of the select field
 * @param string $value of the select field
 * @param Generator $data to use as select field option values
 * @return string HTML of the select element
 */
/*
function select($name, $value, Generator $num_gen, Generator $name_gen) {
    $buffer = sprintf('<select name="%s" style="margin-top:40px">>', htmlspecialchars($name));
	$numAndName = new MultipleIterator();
	$numAndName->attachIterator($num_gen);
	$numAndName->attachIterator($name_gen);
    $buffer .= sprintf('<option value="" disabled selected>בחר/י קורס</option>');
    foreach ($numAndName as list($num, $name)) {
		$buffer .= sprintf(
			'<option%s>%s - %s</option>',
			$value === $num ? ' selected' : '',
			htmlspecialchars($num),
			htmlspecialchars($name)
		);
    }
    $buffer .= "</select>\n";
    return $buffer;
}
*/

/**
 * @param mysqli $mysqli
 * @param string $query
 * @param string $field from query result to use as option values
 * @return Generator
 */
/*
function datasource(mysqli $mysqli, $query, $field) {
    $result = $mysqli->query($query);

    if ($result) foreach ($result as $row) {
        yield $row[$field];
    }
}
*/
?>
