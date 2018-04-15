<?php

include_once '../includes/courses/functions.php';
include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';

define("FILE_TYPE", "exams");

	// login functions
	sec_session_start();

	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		header("registrationFull.php");
		$logged = 'out';
	}

	// drop-down functions
  $db = new mysqli(constant("COURSES_HOST"), constant("COURSES_USER"), 
  				   constant("COURSES_PASSWORD"), constant("COURSES_DATABASE")); //set your database handler
  $query = "SELECT num, name FROM courses"; //SELECT id,cat FROM cat
  $result = $db->query($query);

	$categories = NULL;

  while($row = $result->fetch_assoc()){
    $categories[] = array("id" => $row['num'], "val" => $row['name']);
  }

  $query = "SELECT num, name, faculty FROM courses";
  $result = $db->query($query);

	$subcatsNum = NULL;
	$subcatsName = NULL;

  while($row = $result->fetch_assoc()){
    $subcatsNum[$row['faculty']][] = array("id" => $row['num'], "val" => $row['num']);
	$subcatsName[$row['faculty']][] = array("id" => $row['num'], "val" => $row['name']);
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
  $jsonCats = json_encode($categories);
  $jsonsubcatsNum = json_encode($subcatsNum);
  $jsonsubcatsName = json_encode($subcatsName);

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Javascripts -->
        <script type='text/javascript'>
            <?php
        echo "var categories = $jsonCats; \n";
        echo "var subcatsNum = $jsonsubcatsNum; \n";
		echo "var subcatsName = $jsonsubcatsName; \n";
		echo "var userPoints = $jsonPoints; \n";
      ?>

            function getYear() {
                var max = new Date().getFullYear(),
                    min = max - 20,
                    yearSelect = document.getElementById('year');
                yearSelect.options.length = 0;
                yearSelect.options[0] = new Option('בחר/י שנה', "");
                j = yearSelect.options.length;
                for (var i = max; i >= min; i--) {
                    yearSelect.options[j] = new Option(i);
                    j++;
                }
            }

            function loadCategories() {
                var select = document.getElementById("faculty");
                select.onchange = updatesubcats;
                /*for(var i = 0; i < categories.length; i++){
                  select.options[i] = new Option(categories[i].val,categories[i].id);          
                }*/
            }

            function updatesubcats() {
                var catSelect = this;
                var faculty = this.value;
                var subcatselect = document.getElementById("course");
                subcatselect.options.length = 0; //delete all options if any present
                subcatselect.options[0] = new Option('בחר/י קורס', "");
                subcatselect.options[0].disabled = true;
                for (var i = 1; i <= subcatsNum[faculty].length; i++) {
                    var name = subcatsName[faculty][i - 1].val;
                    subcatselect.options[i] = new Option(subcatsNum[faculty][i - 1].val + '-' +
                        name.replace(/&quot;/g, '\"'),
                        subcatsNum[faculty][i - 1].id + '_' + name.replace(/&quot;/g, '\"'));
                }

            }
        </script>
        <!-- End Javascripts -->
    </head>

    <body id="index_body" onLoad="loadCategories(); getYear()" onLoad="getYear()">
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
        <div class="main" style="margin: 2% 40%;">
            <div class="wrapper">
                <div id="upload_body">
                    <h1>העלאת מבחן</h1>
                    	<h4 style="font-size:12px !important;">*בשלב זה ניתן להעלות רק קבצי PDF ששם באותיות אנגליות ומספרים</h4>

                    <div id="upload_div">
                        <form action="php/upload_form/ajax.php" method="post" enctype="multipart/form-data">
                            <!-- user title -->
                            <select name="faculty" id="faculty" required>
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

                            <select id='course' name="courseNum" required>
                                <option value="" disabled selected>בחר/י קורס</option>
                            </select>

                            <!-- file num -->
                            <input type="hidden" name="<?php echo FILE_TYPE ?>Num" id="num" placeholder="שבוע מספר" required value="1">

                            <!-- file num -->
                            <input type="hidden" name="<?php echo FILE_TYPE ?>Name" id="num" placeholder="נושא הסיכום" value="a">

                            <!-- year -->
                            <select id="year" name="year" required></select>

                            <select name="semester" id="semester" required>
                                <option value="" disabled selected>בחר/י סמסטר</option>
                                <option value='winter'>חורף</option>
                                <option value='spring'>אביב</option>
                                <option value='summer'>קיץ</option>
                            </select>

                            <input type="hidden" name="id" value="<?php echo $_SESSION[ 'user_id'] ?>">
                            <input type="hidden" name="username" value="<?php echo $_SESSION[ 'username'] ?>">
                            <input type="hidden" name="type" value="<?php echo FILE_TYPE ?>">

                            <!-- <CTA></CTA> -->
                            <input type="file" name="fileToUpload" id="fileToUpload" required>
                            <button type="submit" class="button2" name="action" id="upload_submit" value="upload" style="margin-top:50px;
						direction:rtl;">הוסיפו</button>
                        </form>

                    </div>

                </div>
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
