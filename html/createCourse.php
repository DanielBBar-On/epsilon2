<?php

include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
	header("LocationregistrationFull.php");
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet" href="css/upload_form/upload_form_style.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/sidebar/sidebar_style.css">
        <link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">

        <!-- Javascripts -->
        <script type='text/javascript'>
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
        <h1 style="text-align:center;
			margin-right: 30%;">הוספת קורס</h1>
        <div id="upload_body">

            <div id="upload_div">
                <form action="php/upload_form/ajax.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    <!-- user title -->
                    <select name="faculty" id="faculty" placeholder="xx" required>
                        <option value="" disabled selected>בחר/י פקולטה</option>
                        <option value="Ezrachit">הפקולטה להנדסה אזרחית וסביבתית</option>
                        <option value="Mechonot">הפקולטה להנדסת מכונות</option>
                        <option value="Chashmal">הפקולטה להנדסת חשמל</option>
                        <option value="Chimit">הפקולטה להנדסה כימית</option>
                        <option value="Mazon">הפקולטה להנדסת מזון וביוטכנולוגיה</option>
                        <option value="Chalal">הפקולטה להנדסת אוירונוטיקה וחלל</option>
                        <option value="Taasiya">הפקולטה להנדסת תעשיה וניהול</option>
                        <option value="Math">הפקולטה למתמטיקה</option>
                        <option value="Physics">הפקולטה לפיזיקה</option>
                        <option value="Chem">הפקולטה לכימיה</option>
                        <option value="Bio">הפקולטה לביולוגיה</option>
                        <option value="Arch">הפקולטה לארכיטקטורה ובינוי ערים</option>
                        <option value="Chinoch">הפקולטה לחינוך למדע וטכנולוגיה</option>
                        <option value="Madmach">הפקולטה למדעי המחשב</option>
                        <option value="Medicene">הפקולטה לרפואה</option>
                        <option value="Chomarim">הפקוטה למדע והנדסה של חומרים</option>
                        <option value="Human">המחלקה ללימודים הומניסטיים ואמנויות</option>
                        <option value="Biomed">הפקולטה להנדסה ביורפואית</option>
                    </select>

                    <!-- first name -->
                    <input type="upload_text" name="courseNum" id="courseNum" placeholder="מספר קורס" required>

                    <!-- last name -->
                    <input type="upload_text" name="courseName" id="courseName" placeholder="שם הקורס" required>

                    <!-- <CTA></CTA> -->
                    <button type="submit" class="button2" name="action" id="upload_submit" value="create" style="margin-top:50px;
						direction:rtl;">הוסיפו קורס</button>
                    <!-- <CTA></CTA> -->
                    <!--<input type="submit" class="button2" name="action" id="upload_submit" value="remove">-->
                </form>
            </div>

        </div>
    </body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/upload_form/upload_form_index.js"></script>
    <!-- /#wrapper -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.2.min.js"></script>

    </html>
