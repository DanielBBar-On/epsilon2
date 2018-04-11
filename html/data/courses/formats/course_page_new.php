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
        <!--<link rel="stylesheet" href="../../../css/text_divider/text_divider_style.css">

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
                    lecturesSelect.options[i] = new Option(lecturesCategories[i - 1].val, lecturesCategories[i - 1].id);
                }

                var tutorialsSelect = document.getElementById('tutorials');
                tutorialsSelect.options[0] = new Option('בחרו תרגול');
                tutorialsSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= tutorialsCategories.length; i++) {
                    tutorialsSelect.options[i] = new Option(tutorialsCategories[i - 1].val, tutorialsCategories[i - 1].id);
                }

                var homeworkSelect = document.getElementById('homework');
                homeworkSelect.options[0] = new Option('בחרו ש"ב');
                homeworkSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= homeworkCategories.length; i++) {
                    homeworkSelect.options[i] = new Option(homeworkCategories[i - 1].val, homeworkCategories[i - 1].id);
                }

                var summariesSelect = document.getElementById('summaries');
                summariesSelect.options[0] = new Option('בחרו סיכום');
                summariesSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= summariesCategories.length; i++) {
                    summariesSelect.options[i] = new Option(summariesCategories[i - 1].val, summariesCategories[i - 1].id);
                }

                var examsSelect = document.getElementById('exams');
                examsSelect.options[0] = new Option('בחרו בחינה');
                examsSelect.options[0].disabled = true;
                //select.onchange = updatesubcats;
                for (var i = 1; i <= examsCategories.length; i++) {
                    examsSelect.options[i] = new Option(examsCategories[i - 1].val, examsCategories[i - 1].id);
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
    </div>

    <body id="index_body" onLoad="loadCategories()">
        <div id="heading" style="text-align: center;
						 vertical-align: middle;">
            <h1> <?php echo constant("COURSE_NUM"); ?> </h1>
        </div>
        <div id="lecturesDiv" style="float:right;
							 width:15%;
                             padding: 10px;">
            <select id='lectures' style="margin-top:40px;
    							 direction: rtl;">
            </select>
            <input type="submit" class="button2" name="action" id="upload_submit" value="חיפוש" style="margin-top:50px" />
        </div>
        <div id="tutorialsDiv" style="float:right;
							  width:15%;
                              padding: 10px;">
            <select id='tutorials' style="margin-top:40px;
    							  direction: rtl;">
            </select>
            <input type="submit" class="button2" name="action" id="upload_submit" value="חיפוש" style="margin-top:50px" />
        </div>
        <div id="homeworkDiv" style="float:right;
							 width:15%;
                             padding: 10px;">
            <select id='homework' style="margin-top:40px;
    							 direction: rtl;">
            </select>
            <input type="submit" class="button2" name="action" id="upload_submit" value="חיפוש" style="margin-top:50px" />
        </div>
        <div id="summariesDiv" style="float:right;
							  width:15%;
                              padding: 10px;">
            <select id='summaries' style="margin-top:40px;
    							  direction: rtl;">
            </select>
            <input type="submit" class="button2" name="action" id="upload_submit" value="חיפוש" style="margin-top:50px" />
        </div>
        <br>
        <div id="examsDiv" style="float:center;
						  width:15%;
                          margin: 0 auto;">
            <select id='exams' style="margin-top:40px;
                              direction: rtl;">
            </select>
            <input type="submit" class="button2" name="action" id="upload_submit" value="חיפוש" style="margin-top:50px" />
        </div>
    </body>
    <script src="../../../js/bootstrap.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="../../../js/jquery-1.11.2.min.js"></script>
    <!-- /#wrapper -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/upload_form/upload_form_index.js"></script>
    </div>

    </html>