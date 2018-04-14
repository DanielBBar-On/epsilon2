<?php

include_once '../includes/courses/functions.php';
include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';

	// login functions
	sec_session_start();
	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		$logged = 'out';
	}

		  $query = "SELECT * FROM members WHERE username = \"" . $_SESSION['username'] . "\"";

	  $points = -1;

	  $result = $mysqli->query($query);

	  while($row = $result->fetch_assoc()){
		  $points = $row['point'];
	  }

	  $jsonPoints = json_encode($points);

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Epsilon</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet" href="css/upload_form/upload_form_style.css">
        <link rel="stylesheet" href="css/text_divider/text_divider_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Javascripts -->

        <!-- End Javascripts -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            <?php
	echo "var userPoints = $jsonPoints; \n";
	?>
        </script>
    </head>

    <body id="index_body">
        <div id="icons" style="width: 100%;
			text-align:center;">
            <span class="container-fluid" style="float:left;
										margin-top:5px;">
			<a  href="index.php">
			<img src="images/logo-white.png" style="width:39.5px;
												height:auto;
												padding:10px;">
												</a>
				<p style="color:#FCFCFC;">דף הבית</p>
				</span>
            <?php
			if (login_check($mysqli) == false) { ?>
                <span class="container-fluid" style="float:left;
												">
			<a  href="registrationFull.php">
			<i class="fa fa-sign-in" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"></i>
												</a>
				<p style="color:#FCFCFC;">התחברות/הרשמה</p>
				</span>
                <?php } else { ?>
                    <span class="container-fluid" style="float:left;">
		<a  href="includes/logout.php">
			<i class="fa fa-sign-out" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"></i>
												</a>
				<p style="color:#FCFCFC;">התנתקות</p>
					</span>
                    <?php } 
			if (login_check($mysqli) == true) { ?>
                        <span class="container-fluid" style="float:left;">
			<a  href="createCourse.php">
			<i class="fa fa-graduation-cap" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
												</a>
				<p style="color:#FCFCFC;">הוספת קורס</p>
			</span>
                        <?php }?>
                            <?php
			if (login_check($mysqli) == true) { ?>
                                <span class="container-fluid" style="float:left;">
			<a  href="uploadFile.php">
			<i class="fa fa-book" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
												</a>
				<p style="color:#FCFCFC;">העלאת קובץ</p>
			</span>
                                <?php }?>
                                    <?php
			if (login_check($mysqli) == true) { ?>
                                        <span class="container-fluid" style="float:left;">
			<i class="fa fa-user" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
				<p style="color:#FCFCFC;"> 

                        <script> document.write("(" + userPoints + " נקודות)") </script>
                        <?php echo $_SESSION['username']; ?> 
                        </p>
			</span>
                                        <?php }?>

        </div>
        <br>
        <div id='file_types' style="vertical-align:central;
    							text-align:center;
                                margin: 15% 23%;">
            <span class="container-fluid" style="float:right;">
        	<a  href="uploadLecture.php">
				<i class="fa fa-calendar-check-o" style="font-size:84px;
												color:#FCFCFC;
												margin:auto;
												padding:10px;"> </i>

			</a>
			<p style="color:#FCFCFC;">העלאת הרצאה</p>
        </span>
            <span class="container-fluid" style="float:right;">
        	<a  href="uploadTuorial.php">
				<i class="fa fa-group" style="font-size:84px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
			</a>
			<p style="color:#FCFCFC;">העלאת תרגול</p>
        </span>
            <span class="container-fluid" style="float:right;">
        	<a  href="uploadHomework.php">
				<i class="fa fa-clipboard" style="font-size:84px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
			</a>
			<p style="color:#FCFCFC;">העלאת שיעורי בית</p>
        </span>
            <span class="container-fluid" style="float:right;">
        	<a  href="uploadSummary.php">
				<i class="fa fa-file-o" style="font-size:84px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
			</a>
			<p style="color:#FCFCFC;">העלאת סיכום</p>
        </span>
            <span class="container-fluid" style="float:right;">
        	<a  href="uploadExan.php">
				<i class="fa fa-leanpub" style="font-size:84px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"> </i>
			</a>
			<p style="color:#FCFCFC;">העלאת בחינה</p>
        </span>
        </div>

    </body>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/upload_form/upload_form_index.js"></script>

    <!-- /#wrapper -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.2.min.js"></script>

    </html>