<?php

include_once '../../../../../../includes/courses/functions.php';
include_once '../../../../../../includes/secure_login/db_connect.php';
include_once '../../../../../../includes/secure_login/functions.php';
include_once 'file_info.php';

	// login functions
	sec_session_start();

	if (login_check($mysqli) == true) {
  		$jsonUserId = json_encode($_SESSION['user_id']);
  		$jsonUserName = json_encode($_SESSION['username']);
		$logged = 'in';
	} else {
		header("Location: ../../../../../../registrationFull.php");
		$logged = 'out';
	}

	//////////// get past versions /////////////
    // drop-down functions
       $db = new mysqli(constant("COURSES_HOST"), constant("COURSES_USER"), 
                         constant("COURSES_PASSWORD"), constant("COURSE_NUM")); //connect to course database

        $query = "SELECT * FROM " . constant("FILE_TYPE") . " WHERE num = " . constant("WEEK_NUM") .
				//" AND semester = " . "'" . constant("SEMESTER") . "'" . 
				//" AND year = " . constant("YEAR") .
				" ORDER BY cast(tot_votes as int) DESC"; // get all lecture that are from the same week.

        $result = $db->query($query);
		/*if ($result === TRUE) {
				echo "Successfully connected to DB";
		} else {
				echo "Error: " . $query . "<br>" . $db->error;
		}*/

        $categories = NULL;

        while($row = $result->fetch_assoc()){
			$categories[] = array("id" => $row['path'], "val" => $row['semester'] . " " .
																$row['year'] . " - " .
																$row['tot_votes'] . " votes");
        }

		// get file id
		$query = "SELECT * FROM " . constant("FILE_TYPE") . " WHERE path = \"../../" .
                    constant("FILE_DIR")  . constant("FILE_NAME") . ".php" . "\"";
		
		$result = $db->query($query);
		
		$id = -1;
		
		while ($row = $result->fetch_assoc()){
			$id = $row['id'];
		}
		
        $jsonCats = json_encode($categories);
        $jsonCourseNum = json_encode(constant("COURSE_NUM"));
		$jsonFileId = json_encode($id);
        $jsonType = json_encode(constant("FILE_TYPE"));
		$jsonADDED_BY_EMAIL = json_encode(constant("ADDED_BY_USERNAME"));
		
		$db->close();
?>

    <!doctype html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Epsilon</title>
        <link rel="stylesheet" href="../../../../../css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../../..//css/sidebar/sidebar_style.css">
        <link href="../../../../../css/flat_ui.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../../../../css/pdf_viewer/pdf_viewer_style.css">
        <link rel="stylesheet" href="../../../../../css/show_hide_button/show_hide_style.css">
        <link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../../../../css/forum/forum_style.css">
    </head>

    <!--javascript-->
    <script type='text/javascript'>
        <?php
                echo "var categories = $jsonCats; \n";
            ?>
	
        function loadCategories() {
            var select = document.getElementById("course");
			select.options[0] = new Option('גרסאות קודמות');
            select.options[0].disabled = true;
            for (var i = 1; i <= categories.length; i++) {
                select.options[i] = new Option(categories[i - 1].val, categories[i - 1].id);
            }
        }
    </script>
    <!--end javascript-->

    <body id="index_body" onLoad="loadForum(); loadCategories();" style="margin-top:5%;">
        <div class="row" style="width: 100%;
				text-align:center;">
            <span class="container-fluid" style="float:left;
										margin-top:5px;">
			<a  href="../../../../../index.php">
			<img src="../../../../../images/logo-white.png" style="width:39.5px;
												height:auto;
												padding:10px;">
												</a>
				<p style="color:#FCFCFC;">דף הבית</p>
				</span>
            <?php
			if (login_check($mysqli) == false) { ?>
                <span class="container-fluid" style="float:left;
												">
			<a  href="../../../../../registrationFull.php">
			<i class="fa fa-sign-in" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;"></i>
												</a>
				<p style="color:#FCFCFC;">התחברות/הרשמה</p>
				</span>
                <?php } else { ?>
                    <span class="container-fluid" style="float:left;">
		<a  href="../../../../../includes/logout.php">
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
			<a  href="../../../../../createCourse.php">
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
			<a  href="../../../../../uploadFile.php">
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
        
        <script type='text/javascript'>
            <?php
        echo "var userId = $jsonUserId; \n"; //voter
        echo "var userName = $jsonUserName; \n"; //voter
		echo "var fileId = $jsonFileId; \n";
		echo "var courseNum = $jsonCourseNum; \n";
        echo "var type = $jsonType; \n";
		echo "var ADDED_BY_EMAIL = $jsonADDED_BY_EMAIL; \n";
      ?>

            console.log("userId = " + userId +
                " userName = " + userName +
				" file id = " + fileId +
				" ADDED_BY_EMAIL = " + ADDED_BY_EMAIL);
        </script>
        
        
        <div id="main">
            <div class="row" id="main" style="text-align: center;">
                <div style="text-align: center;
						 vertical-align: middle;
                         ">
                    <a href= "<?php echo "../../../../../data/courses/" . constant("COURSE_NUM") . "/" . constant("COURSE_NUM") . ".php" ?>">
                    <h3 style="color:#FCFCFC;
                            text-align: center;
                            text-decoration:underline;">  <?php echo constant("COURSE_NAME") ?> </h3>
                            </a>
                    <h3 style="color:#FCFCFC;
                            text-align: center;
            			"> הרצאה של שבוע מס' <?php echo htmlentities(constant("WEEK_NUM")) ?> </h3>
                                            <form action="../../../../../php/upload_form/ajax.php" method="post" enctype="multipart/form-data">
                        <select id='course' name="path">
                            <option value="" disabled selected>בחרו גרסא קודמת</option>
                        </select>
<button type="submit" class="button2" name="action" id="upload_submit" value="searchByPath" style="margin-top:50px;
						direction:rtl;" />מצא</button>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <object data="<?php echo FILE ?>" type="application/pdf" 
                		width="85%" height="800px" style="text-align: center;
                        							margin-right: 5%;
                                                    float: right;">
                    <p>It appears you don't have a PDF plugin for this browser. No biggie... you can <a href="resume.pdf">click here to
  download the PDF file.</a></p>
                </object>
			<div id="votes" style="float:right;
                                    margin: 2%;">
            <div class="upvote" style="font-size: 36px;
            						color:#FCFCFC;">
                <a style="cursor:pointer;" onclick="upvoteFile(ADDED_BY_EMAIL);">
                    <i class="fa fa-thumbs-up" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;">
				</i>
                </a>
            </div>
            <div id='fileVotes' class="number-of-votes" style="margin-right: 15px;"> 
            </div>
            <div class="downvote">
                <a style="cursor: pointer;" onclick="downvoteFile(ADDED_BY_EMAIL);">
                    <i class="fa fa-thumbs-down" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;">
				</i>
                </a>
            </div>
            </div>
            </div>
            <div style="text-align:center;"> 
                <textarea id="questionText" type="ask_question" placeholder="שאל שאלה"></textarea>
                <br>
                <input type="submit" class="button2" name="action" id="upload_submit" value="ask" onClick="askQuestion(userName)" />
                <input type="hidden" name="file_path" value="data\courses\formats">
            </div>
        <div class="vue-wrapper">
            <div id="vue"> 
                <div id="questions"> </div>
            </div>
        </div>
        </div>
    </body>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="../../../../../js/show_hide_button/show_hide_button.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.js"></script>
    <script src="../../../../../js/forum/forum_self.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="../../../../../js/bootstrap.js"></script>
    <script src="../../../../../js/bootstrap.min.js"></script>
    <script src="../../../../../js/jquery-1.11.2.min.js"></script>

    </html>