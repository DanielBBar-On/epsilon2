<?php

include_once 'course_info.php';
include_once '../../../../includes/courses/functions.php';
include_once '../../../../includes/secure_login/db_connect.php';
include_once '../../../../includes/secure_login/functions.php';
include_once '../../../../includes/courses/' . constant("COURSE_NUM") .'/db_connect.php';

	// login functions
	sec_session_start();

	if (login_check($loginsqli) == true) {
		$logged = 'in';
	} else {
		header("Location: ../../../../../registrationFull.php");
		$logged = 'out';
	}

	//course specific functions

	// drop-down functions

	//set your database handler 

	function select($table, $db) {
		$query = "SELECT num, name FROM " . $table; //SELECT id,cat FROM cat
		$result = $db->query($query);

		$categories = array();

		if (!empty($result)) {
			while ($row = $result->fetch_assoc()){
				$categories[] = array("id" => $row['num'], "val" => $row['name']);
			}
		}

		switch($table) {
			case 'lectures':
				return json_encode($categories);
				break;
			case 'tutorials':
				return json_encode($categories);
				break;
			case 'homework':
				return json_encode($categories);
				break;
			case 'summaries':
				return json_encode($categories);
				break;
			case 'exams':
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
      ?>

            function loadCategories() {

                var lecturesSelect = document.getElementById('lectures');
                lecturesSelect.options[0] = new Option('בחרו הרצאה');
                lecturesSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= lecturesCategories.length; i++) {
                    /*alert("i is:");
                    alert(i);
                    alert(lecturesCategories[i].id);*/
                    lecturesSelect.options[i] = new Option(
						"שבוע מס\' " + lecturesCategories[i - 1].id + " - " + lecturesCategories[i - 1].val,
						lecturesCategories[i - 1].id + "_" + lecturesCategories[i - 1].val);
                }

                var tutorialsSelect = document.getElementById('tutorials');
                tutorialsSelect.options[0] = new Option('בחרו תרגול');
                tutorialsSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= tutorialsCategories.length; i++) {
                    tutorialsSelect.options[i] = new Option(
						"שבוע מס\' " + tutorialsCategories[i - 1].id + " - " + tutorialsCategories[i - 1].val,
						tutorialsCategories[i - 1].id + "_" + tutorialsCategories[i - 1].val);
                }

                var homeworkSelect = document.getElementById('homework');
                homeworkSelect.options[0] = new Option('בחרו ש"ב');
                homeworkSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= homeworkCategories.length; i++) {
					homeworkSelect.options[i] = new Option(
                    	"שבוע מס\' " + homeworkCategories[i - 1].id + " - " + homeworkCategories[i - 1].val,
						homeworkCategories[i - 1].id + "_" + homeworkCategories[i - 1].val);
                }

                var summariesSelect = document.getElementById('summaries');
                summariesSelect.options[0] = new Option('בחרו סיכום');
                summariesSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= summariesCategories.length; i++) {
					summariesSelect.options[i] = new Option(
                    	"שבוע מס\' " + summariesCategories[i - 1].id + " - " + summariesCategories[i - 1].val,
						summariesCategories[i - 1].id + "_" + summariesCategories[i - 1].val);
                }

                var examsSelect = document.getElementById('exams');
                examsSelect.options[0] = new Option('בחרו בחינה');
                examsSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= examsCategories.length; i++) {
                    examsSelect.options[i] = new Option(
						"שבוע מס\' " + examsCategories[i - 1].id + " - " + examsCategories[i - 1].val,
						examsCategories[i - 1].id + "_" + examsCategories[i - 1].val);
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
            <div style="width: 100%;
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
			if (login_check($loginsqli) == false) { ?>
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
			if (login_check($loginsqli) == true) { ?>
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
			if (login_check($loginsqli) == true) { ?>
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

        </div>
        <br>
        <div style="width:100%;">
        </div>
        <div style="text-align: center;
						 vertical-align: middle;">
            <h1 style="color:#FCFCFC">  <?php echo constant("COURSE_NAME") . " - " . constant("COURSE_NUM"); ?> </h1>
        </div>
            
            <div class="mine messages" style="float:right;
            								width: 40%">
    <div class="message last" style="direction:rtl;">
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
						direction:rtl;" />מצא</button>
        </div>
        <div id="tutorialsDiv" style="float:right;
							  width:25%;
                              padding: 20px;">
            <select id='tutorials' style="margin-top:40px;
    							  direction: rtl;">
            </select>
			<button type="submit" class="button2" name="action" id="upload_submit" value="searchTutorial" style="margin-top:50px;
						direction:rtl;" />מצא</button>
        </div>
        <div id="homeworkDiv" style="float:right;
							 width:25%;
                             padding: 20px;">
            <select id='homework' style="margin-top:40px;
    							 direction: rtl;">
            </select>
			<button type="submit" class="button2" name="action" id="upload_submit" value="searchHomework" style="margin-top:50px;
						direction:rtl;" />מצא</button>
        </div>
        <div id="summariesDiv" style="float:right;
							  width:25%;
                              padding: 20px;">
            <select id='summaries' style="margin-top:40px;
    							  direction: rtl;">
            </select>
			<button type="submit" class="button2" name="action" id="upload_submit" value="searchSummaries" style="margin-top:50px;
						direction:rtl;" />מצא</button>
        </div>
        <br>
        <div id="examsDiv" style="float:center;
						  width:25%;
                          margin: 0 auto;">
            <select id='exams' style="margin-top:40px;
                              direction: rtl;">
            </select>
			<button type="submit" class="button2" name="action" id="upload_submit" value="searchSummaries" style="margin-top:50px;
						direction:rtl;" />מצא</button>
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