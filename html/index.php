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
<link rel="stylesheet" href="css/text_divider/text_divider_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Javascripts --> 
<script type='text/javascript'>
      <?php
        echo "var categories = $jsonCats; \n";
        echo "var subcatsNum = $jsonsubcatsNum; \n";
		echo "var subcatsName = $jsonsubcatsName; \n";
      ?>
      function loadCategories(){
        var select = document.getElementById("faculty");
        select.onchange = updatesubcats;
        /*for(var i = 0; i < categories.length; i++){
          select.options[i] = new Option(categories[i].val,categories[i].id);          
        }*/
      }
      function updatesubcats(){
        var catSelect = this;
        var faculty = this.value;
        var subcatselect = document.getElementById("courseNum");
        subcatselect.options.length = 0; //delete all options if any present
		subcatselect.options[0] = new Option('בחר/י קורס');
		subcatselect.options[0].disabled = true;
        for(var i = 1; i <= subcatsNum[faculty].length; i++){
          subcatselect.options[i] = new Option(subcatsNum[faculty][i-1].val + '-' +
		  									   subcatsName[faculty][i-1].val,
											   subcatsNum[faculty][i-1].id);
        }
      }
    </script> 
<!-- End Javascripts --> 
<link rel="stylesheet" href="css/bootstrap.css">
<!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="css/sidebar/sidebar_style.css">-->
<link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">
</head>

<body id="index_body" onload='loadCategories()'>
<div style="width: 100%">
	<span class="container-fluid" style="float:left;">
	<?php
        if (login_check($mysqli) == false) { ?>
        <a  href="registrationFull.php">
        <i class="fa fa-sign-in" style="font-size:36px;
    	    								color:#FCFCFC;
                                            margin:auto;
                                            padding: 10px;"></i>
                                            </a>
			<p style="color:#FCFCFC;">התחברות/הרשמה</p>     
    <?php } else { ?>
    <a  href="includes/logout.php">
        <i class="fa fa-sign-out" style="font-size:36px;
    	    								color:#FCFCFC;
                                            margin:auto;
                                            padding: 10px;"></i>
                                            </a>
			<p style="color:#FCFCFC;">התנתקות</p>
    <?php } ?>
    </span>
    <?php
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
  <div style="width:100%;">
  </div>
  <div style="float:right;
  			width:40%;
            margin-right:10%;
            vertical-align:central;">
    <div style="text-align:center;"> 
    <img alt="logo" src="images/logo.png" 
      										style="margin-top:0%; width:100%; height:100%;"> </div>
  </div>
  <div style="float:right;
  			  width:30%; 
              height:100vh;
              margin-top:0%">
    
    <!--<p class="or-divider italic" dir="rtl">או</p>-->
    <div id="upload_div" style="height:inherit;">
      <form action="php/upload_form/ajax.php" method="post" enctype="multipart/form-data" 
        				style="
                        	   text-align:center;
                               margin-top:0%;
                               width:100%;">
        <!-- user title -->
        <select id="faculty" name="faculty">
          <option value="" disabled selected>בחר/י פקולטה</option>
          <option value="Ezrachit"	>הפקולטה להנדסה אזרחית וסביבתית</option>
          <option value="Mechonot"	>הפקולטה להנדסת מכונות</option>
          <option value="Chashmal"	>הפקולטה להנדסת חשמל</option>
          <option value="Chimit"		>הפקולטה להנדסה כימית</option>
          <option value="Mazon"		>הפקולטה להנדסת מזון וביוטכנולוגיה</option>
          <option value="Chalal"		>הפקולטה להנדסת אוירונוטיקה וחלל</option>
          <option value="Taasiya"		>הפקולטה להנדסת תעשיה וניהול</option>
          <option value="Math"		>הפקולטה למתמטיקה</option>
          <option value="Physics"		>הפקולטה לפיזיקה</option>
          <option value="Chem"		>הפקולטה לכימיה</option>
          <option value="Bio"			>הפקולטה לביולוגיה</option>
          <option value="Arch"		>הפקולטה לארכיטקטורה ובינוי ערים</option>
          <option value="Chinoch"		>הפקולטה לחינוך למדע וטכנולוגיה</option>
          <option value="Madmach"		>הפקולטה למדעי המחשב</option>
          <option value="Medicene"	>הפקולטה לרפואה</option>
          <option value="Chomarim"	>הפקוטה למדע והנדסה של חומרים</option>
          <option value="Human"		>המחלקה ללימודים הומניסטיים ואמנויות</option>
          <option value="Biomed"		>הפקולטה להנדסה ביורפואית</option>
        </select>
        <br>
        
        <!-- user title --> 
        <!--style for select is in the select function-->
        <select id='courseNum' name='courseNum' style="margin-top:40px">
          <option value="" disabled selected>בחר/י קורס</option>
        </select>
        <button type="submit" class="button2" name="action" id="upload_submit" value="search"
        		style="margin-top:50px;
                	direction:rtl;"/>חיפוש</button>
      </form>	
    </div>
  </div>
  <!--<div style="float:right; width:20%; margin-right:5%">
  	<a href="uploadLecture.php">
    	<input type="submit" class="button2" name="action" id="upload_submit" value="הוסף הרצאה" 
        	   					style="margin-top:50px"/>
    </a>
    <a href="uploadTutorial.php">
    	<input type="submit" class="button2" name="action" id="upload_submit" value="הוסף תרגול" 
        	   					style="margin-top:50px"/>
    </a>
    <a href="uploadHomeWork.php">
    	<input type="submit" class="button2" name="action" id="upload_submit" value="הוסף שיעורי בית" 
        	   					style="margin-top:50px"/>
    </a>
    <a href="uploadSummary.php">
    	<input type="submit" class="button2" name="action" id="upload_submit" value="הוסף סיכום" 
        	   					style="margin-top:50px"/>
    </a>
    <a href="uploadExam.php">
    	<input type="submit" class="button2" name="action" id="upload_submit" value="הוסף מבחן" 
        	   					style="margin-top:50px"/>
    </a>
  </div>-->
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