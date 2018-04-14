<?php
include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

	$jsonPoints = json_encode(0);
	if($logged == 'in') {
	  $query = "SELECT * FROM members WHERE username = \"" . $_SESSION['username'] . "\"";

	  $points = -1;

	  $result = $mysqli->query($query);

	  while($row = $result->fetch_assoc()){
		  $points = $row['point'];
	  }

	  $jsonPoints = json_encode($points);
	}

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Epsilon</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/sidebar/sidebar_style.css">
        <link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet" href="css/registration/login_style.css">
        <script type="text/JavaScript" src="js/registration/sha512.js"></script>
        <script type="text/JavaScript" src="js/registration/forms.js"></script>
        <script type="text/javascript">
            <?php
	echo "var userPoints = $jsonPoints; \n";
	?>
        </script>
    </head>

    <body id="index_body">
        <div class="row" style="width: 100%;
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
			<a  href="uploadLecture.php">
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
        <div style="width:100%;">
        </div>
        <div class="form">
            <div class="tab-content">
                <div id="login">
                    <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
                        <h1>ברוכים הבאים!</h1>
                        <h1 dir="rtl" align="center">ההרשמה הושלמה בהצלחה. אנא הכניסו מייל וסיסמא על מנת להתחבר</h1>
                        <form action="includes/process_login.php" method="post" name="login_form">
                            <div class="field-wrap">
                                <label dir="rtl"> אי מייל <span class="req">*</span> </label>
                                <input type="text" name="email" required autocomplete="off" />
                            </div>
                            <div class="field-wrap">
                                <label> סיסמה<span class="req">*</span> </label>
                                <input type="password" name="password" id="password" required autocomplete="off" />
                            </div>
                            <button class="button button-block" type="button" value="Login" onclick="formhash(this.form, this.form.password);"> התחבר </button>
                            <?php	
        if (login_check($mysqli) == true) {
 						//Todo: do we want to add this cute little messages?
                        //echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';

            //echo '<p>Do you want to change user? <a href="/includes/logout.php">Log out</a>.</p>';
        } else {
                        //echo '<p>Currently logged ' . $logged . '.</p>';
                        //echo "<p>If you don't have a login, please <a href='register.php'>register</a></p>";
                }
		?>
                        </form>
                </div>
            </div>
            <!-- tab-content -->

        </div>
    </body>
    <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/registration/index.js"></script>
    <!-- /#wrapper -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.2.min.js"></script>

    </html>