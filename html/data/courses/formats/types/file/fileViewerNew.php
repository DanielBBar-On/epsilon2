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
		header("Location: registrationFull.php");
		$logged = 'out';
	}

	//////////// get past versions /////////////
    // drop-down functions
       $db = new mysqli(constant("COURSES_HOST"), constant("COURSES_USER"), 
                         constant("COURSES_PASSWORD"), constant("COURSE_NUM")); //connect to course database

        $query = "SELECT * FROM lectures WHERE num = " . constant("WEEK_NUM") .
				" AND semester = " . "'" . constant("SEMESTER") . "'" . 
				" AND year = " . constant("YEAR") .
				" ORDER BY tot_votes"; // get all lecture that are from the same week.

        $result = $db->query($query);

        $categories = NULL;

        while($row = $result->fetch_assoc()){
			$categories[] = array("id" => $row['path'], "val" => $row['semester'] . " " .
																$row['year'] . " - " .
																$row['tot_votes'] . " votes");
        }

        $jsonCats = json_encode($categories);

?>
    <!doctype html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Epsilon</title>
        <link rel="stylesheet" href="../../../../../css/bootstrap.css">
        <!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
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
            for (var i = 0; i < categories.length; i++) {
                select.options[i] = new Option(categories[i].val, categories[i].id);
            }
        }
    </script>
    <!--end javascript-->

    <body id="index_body" onLoad="loadForum(); loadCategories();" style="margin-top:5%;">
        <div style="width: 100%;
				text-align:center;">
            <span class="container-fluid" style="float:left;
										margin-top:5px;">
			<a  href="index.php">
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

        </div>
        <br>
        <script type='text/javascript'>
            <?php
        echo "var userId = $jsonUserId; \n";
        echo "var userName = $jsonUserName; \n";
      ?>
        </script>
        <div id="main">
            <div style="text-align: center;
						 vertical-align: middle;
                         margin-right: 20%">
                <h1 style="color:#FCFCFC">  <?php echo constant("COURSE_NAME") ?> </h1>
                <h1 style="color:#FCFCFC;
            			"> הרצאה של שבוע מס' <?php echo htmlentities(constant("WEEK_NUM")) ?> </h1>
            </div>
            <div class="row">
                <div class="col-md-12" id="question" style="float:right; margin-top: 5%;" align="center">
                    <script type="text/javascript">
                        function hasClass(ele, cls) {
                            return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
                        }

                        function changeClass() {
                            if (hasClass(document.getElementById("question"), "col-md-6")) {
                                document.getElementById("question").className = "col-md-12";
                            } else {
                                document.getElementById("question").className = "col-md-6";
                            }
                        }
                    </script>
                    <!-- responsive iframe -->
                    <!-- ============== -->
                    <div id="Iframe-Cicis-Menu-To-Go-Question" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
                        <div class="responsive-wrapper 
     responsive-wrapper-padding-bottom-90pct" style="-webkit-overflow-scrolling: touch; overflow: auto;">
                            <iframe src="<?php echo FILE ?>">
                                <p style="font-size: 110%;"><em><strong>ERROR: </strong> An &#105;frame should be displayed here but your brow	ser version does not support &#105;frames.</em> Please update your browser to its most recent version and try again, or access the file
                                    <a href="https://drive.google.com/file/d/0BxrMaW3xINrsR3h2cWx0OUlwRms/preview"></a>
                                </p>
                            </iframe>
                        </div>
                    </div>
        <div class="upvote">
        	<a onclick="upvoteFile()">
            	<i class="fa fa-thumbs-up" style="font-size:36px;
												color:#FCFCFC;
												margin:auto;
												padding: 10px;">
				</i>
			</a>
        </div>
        <div id='fileVotes' class="number-of-votes">
        </div>
        <div class="downvote">
        	<a href="" onclick="downvoteFile()">
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
                <div style="float: right">
                    <form action="../../../../../php/upload_form/ajax.php" method="post" enctype="multipart/form-data">
                        <select id='course' name="path">
                            <option value="" disabled selected>בחר/י קורס</option>
                        </select>
                    </form>
                </div>
                <div style="float: right;">
                    <input type="submit" class="button2" name="action" id="upload_submit" value="searchByPath" />

                    <textarea id="questionText" type="ask_question" placeholder="שאל שאלה"></textarea>
                    <br>
                    <input type="submit" class="button2" name="action" id="upload_submit" value="ask" onClick="askQuestion()" />
                    <input type="hidden" name="file_path" value="data\courses\formats">
                    <input type="submit" class="button2" name="action" id="upload_submit" value="send_json" onClick="saveForum()" />
                </div>
            </div>
            <div class="vue-wrapper">
                <div id="vue">
                    <div class="search-area">
                        <h1>דיונים</h1>
                        <div class="input-wrapper"> <i class="fa fa-search"></i>
                            <input v-model="searchString" type="text" placeholder="Have a question? Search for answers with keywords" />
                        </div>
                        <button @click="resetSearch()">נקה</button>
                    </div>
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