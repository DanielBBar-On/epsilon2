<?php

include_once 'course_info.php';
include_once '../../../../includes/courses/functions.php';
include_once '../../../../includes/secure_login/db_connect.php';
include_once '../../../../includes/secure_login/functions.php';
include_once '../../../../includes/courses/' . constant("COURSE_NUM") .'/db_connect.php';

	// login functions
	sec_session_start();

	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		header("Location: ../../../../../registrationFull.php");
		$logged = 'out';
	}

	//course specific functions

	// drop-down functions

	//set your database handler 

		$query = "SELECT * FROM members WHERE username = \"" . $_SESSION['username'] . "\"";

	$points = -1;

	$result = $mysqli->query($query);

	while($row = $result->fetch_assoc()){
	  $points = $row['point'];
	}

	$jsonPoints = json_encode($points);

	function select($table, $db) {
		//$query = "SELECT num, name FROM " . $table; //SELECT id,cat FROM cat
		switch($table) {
			case 'lectures':
				$query = "SELECT tt.num, tt.* 
					FROM " . $table . " tt
					INNER JOIN (
						SELECT num, MAX(tot_votes) AS MaxTotVotes
						FROM " . $table . "
						GROUP BY num) groupedtt
						ON tt.num = groupedtt.num
						AND tt.tot_votes = groupedtt.MaxTotVotes
						GROUP BY tt.num";

				$result = $db->query($query);

				$categories = array();

				if (!empty($result)) {
					while ($row = $result->fetch_assoc()){
					$categories[] = array("id" => $row['path'],
								"val" => "שבוע מס' " . $row['num'] . " - " . $row['name']);
					}
				}
				return json_encode($categories);
				break;
				
			case 'tutorials':
				$query = "SELECT tt.num, tt.* 
					FROM " . $table . " tt
					INNER JOIN (
						SELECT num, MAX(tot_votes) AS MaxTotVotes
						FROM " . $table . "
						GROUP BY num) groupedtt
						ON tt.num = groupedtt.num
						AND tt.tot_votes = groupedtt.MaxTotVotes
						GROUP BY tt.num";

				$result = $db->query($query);

				$categories = array();

				if (!empty($result)) {
					while ($row = $result->fetch_assoc()){
					$categories[] = array("id" => $row['path'],
						"val" => "שבוע מס' " . $row['num'] . " - " . $row['name']);
					}
				}
				return json_encode($categories);
				break;
				
			case 'homework':
				$query = "SELECT tt.num, tt.* 
					FROM " . $table . " tt
					INNER JOIN (
						SELECT num, MAX(tot_votes) AS MaxTotVotes
						FROM " . $table . "
						GROUP BY num) groupedtt
						ON tt.num = groupedtt.num
						AND tt.tot_votes = groupedtt.MaxTotVotes
						GROUP BY tt.num";

				$result = $db->query($query);

				$categories = array();

				if (!empty($result)) {
					while ($row = $result->fetch_assoc()){
					$categories[] = array("id" => $row['path'],
						"val" => "שבוע מס' " . $row['num'] . " - " . $row['name']);
					}
				}
				return json_encode($categories);
				break;
			case 'summaries':
				$query = "SELECT * FROM " . $table .
						" ORDER BY year DESC, semester";

				$result = $db->query($query);

				$categories = array();

				if (!empty($result)) {
					while ($row = $result->fetch_assoc()){
					$categories[] = array("id" => $row['path'],
							"val" => $row['name']);
					}
				}
				return json_encode($categories);
				break;
			case 'exams':
				$query = "SELECT * FROM " . $table .
						" ORDER BY year DESC, semester";

				$result = $db->query($query);

				$categories = array();

				if (!empty($result)) {
					while ($row = $result->fetch_assoc()){
					$categories[] = array("id" => $row['path'],
							"val" => $row['name']);
					}
				}
				return json_encode($categories);
				break;
		}

	}

	$jsonLectures = select('lectures', $my_course_sqli);
	$jsonTutorials = select('tutorials', $my_course_sqli);
	$jsonHomework = select('homework', $my_course_sqli);
	$jsonSummaries = select('summaries', $my_course_sqli);
	$jsonExams = select('exams', $my_course_sqli);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Epsilon</title>
        <link rel="stylesheet" href="../../../css/bootstrap.css">
        <link href="../../../css/flat_ui.min.css" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet" href="../../../css/upload_form/upload_form_style.css">
        <link rel="stylesheet" href="../../../css/ios/ios_style.css">
        <link rel="stylesheet" href="../../../css/text_divider/text_divider_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Javascripts -->
        <script type='text/javascript'>
            <?php
        echo "var lecturesCategories = $jsonLectures; \n";
		echo "var tutorialsCategories = $jsonTutorials; \n";
		echo "var homeworkCategories = $jsonHomework; \n";
		echo "var summariesCategories = $jsonSummaries; \n";
		echo "var examsCategories = $jsonExams; \n";
		echo "var userPoints = $jsonPoints; \n";
      ?>

            function loadCategories() {

                var lecturesSelect = document.getElementById('lectures');
                lecturesSelect.options[0] = new Option('בחרו הרצאה');
                lecturesSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= lecturesCategories.length; i++) {
                    lecturesSelect.options[i] = new Option(
                        lecturesCategories[i - 1].val,
                        lecturesCategories[i - 1].id);
                }

                var tutorialsSelect = document.getElementById('tutorials');
                tutorialsSelect.options[0] = new Option('בחרו תרגול');
                tutorialsSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= tutorialsCategories.length; i++) {
                    tutorialsSelect.options[i] = new Option(
                        tutorialsCategories[i - 1].val,
                        tutorialsCategories[i - 1].id);
                }

                var homeworkSelect = document.getElementById('homework');
                homeworkSelect.options[0] = new Option('בחרו ש"ב');
                homeworkSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= homeworkCategories.length; i++) {
                    homeworkSelect.options[i] = new Option(
                        homeworkCategories[i - 1].val,
                        homeworkCategories[i - 1].id);
                }

                var summariesSelect = document.getElementById('summaries');
                summariesSelect.options[0] = new Option('בחרו סיכום');
                summariesSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= summariesCategories.length; i++) {
                    summariesSelect.options[i] = new Option(
                        summariesCategories[i - 1].val,
                        summariesCategories[i - 1].id);
                }

                var examsSelect = document.getElementById('exams');
                examsSelect.options[0] = new Option('בחרו בחינה');
                examsSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= examsCategories.length; i++) {
                    examsSelect.options[i] = new Option(
                        examsCategories[i - 1].val,
                        examsCategories[i - 1].id);
                }

            }
            /*function updatesubcats(){
        var catSelect = this;
        var faculty = this.value;
        var subcatselect = document.getElementById("course");
        subcatselect.options.length = 0; //delete all options if any present
		subcatselect.options[0] = new Option('בחר/י קורס');
		subcatselect.options[0].disabled = true;
        for(var i = 1; i <= subcatsNum[faculty].length; i++){
          subcatselect.options[i] = new Option(subcatsNum[faculty][i].val + '-' +
		  									   subcatsName[faculty][i].val,
											   subcatsNum[faculty][i].id);
        }
      }*/
        </script>
        <!-- End Javascripts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>

    <body id="index_body" onLoad="loadCategories()">
        <div class="row" style="width: 100%;
				text-align:center;">
            <span class="container-fluid" style="float:left;
										margin-top:5px;">
			<a  href="../../../index.php">
			<img src="../../../images/logo-white.png" style="width:39.5px;
												height:auto;
												padding:10px;">
												</a>
				<p style="color:#FCFCFC;">דף הבית</p>
				</span>
            <?php
			if (login_check($mysqli) == false) { ?>
                <span class="container-fluid" style="float:left;
												">
			<a  href="../../../registrationFull.php">
			<i class="fa fa-sign-in" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"></i>
												</a>
				<p style="color:#FCFCFC;">התחברות/הרשמה</p>
				</span>
                <?php } else { ?>
                    <span class="container-fluid" style="float:left;">
		<a  href="../../../includes/logout.php">
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
			<a  href="../../../createCourse.php">
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
			<a  href="../../../uploadFile.php">
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
        <div class="row" style="text-align: center;
						 vertical-align: middle;">
            <h1 style="color:#FCFCFC">  <?php echo constant("COURSE_NAME") . " - " . constant("COURSE_NUM"); ?> </h1>
        </div>

        <div class="mine messages" style="float:right;
            								width: 40%">
            <div class="message last" style="direction:rtl;
    								font-size:24px;">
                ברוכים הבאים לעמוד הקורס. כאן ניתן למצוא את כל חומרי הקורס. להתחלה בחרו סוג קובץ או העלו קובץ חדש.
            </div>
        </div>
        <div id="upload_div" style="float:right;
            	width: 60%">
            <form action="../../../php/upload_form/ajax.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="courseNum" value="<?php echo constant("COURSE_NUM"); ?>">
                <div id="lecturesDiv" style="float:right;
							 width:25%;
                             padding: 20px;">
                    <select id='lectures' name='lectures' style="margin-top:40px;
    							 direction: rtl;">
                    </select>
                    <button type="submit" class="button2" name="action" id="upload_submit" value="searchLecture" style="margin-top:50px;
						direction:rtl;" >מצא</button>
                </div>
                <div id="tutorialsDiv" style="float:right;
							  width:25%;
                              padding: 20px;">
                    <select id='tutorials' style="margin-top:40px;
    							  direction: rtl;">
                    </select>
                    <button type="submit" class="button2" name="action" id="upload_submit" value="searchTutorial" style="margin-top:50px;
						direction:rtl;">מצא</button>
                </div>
                <div id="homeworkDiv" style="float:right;
							 width:25%;
                             padding: 20px;">
                    <select id='homework' style="margin-top:40px;
    							 direction: rtl;">
                    </select>
                    <button type="submit" class="button2" name="action" id="upload_submit" value="searchHomework" style="margin-top:50px;
						direction:rtl;">מצא</button>
                </div>
                <div id="summariesDiv" style="float:right;
							  width:25%;
                              padding: 20px;">
                    <select id='summaries' style="margin-top:40px;
    							  direction: rtl;">
                    </select>
                    <button type="submit" class="button2" name="action" id="upload_submit" value="searchSummaries" style="margin-top:50px;
						direction:rtl;">מצא</button>
                </div>
                <br>
                <div id="examsDiv" style="float:center;
						  width:25%;
                          margin: 0 auto;">
                    <select id='exams' style="margin-top:40px;
                              direction: rtl;">
                    </select>
                    <button type="submit" class="button2" name="action" id="upload_submit" value="searchSummaries" style="margin-top:50px;
						direction:rtl;">מצא</button>
                </div>
            </form>
        </div>
    </body>
    <script src="../../../js/jquery-1.11.2.min.js"></script>
    <script src="../../../js/bootstrap.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <!-- /#wrapper -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="../../../js/upload_form/upload_form_index.js"></script>

    </html>