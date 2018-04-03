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

  while($row = $result->fetch_assoc()){
    $categories[] = array("id" => $row['num'], "val" => $row['name']);
  }

  $query = "SELECT num, name, faculty FROM courses";
  $result = $db->query($query);

  while($row = $result->fetch_assoc()){
    $subcatsNum[$row['faculty']][] = array("id" => $row['num'], "val" => $row['num']);
	$subcatsName[$row['faculty']][] = array("id" => $row['num'], "val" => $row['name']);
  }

  $jsonCats = json_encode($categories);
  $jsonsubcatsNum = json_encode($subcatsNum);
  $jsonsubcatsName = json_encode($subcatsName);


?>
<script src="js/jquery-1.11.2.min.js"></script>
<!DOCTYPE html>
<html>
<!-- InstanceBegin template="/templates/sidebarBeforeSignIn.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Epsilon</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/upload_form/upload_form_style.css">
<link rel="stylesheet" href="css/text_divider/text_divider_style.css">

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
        var subcatselect = document.getElementById("course");
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
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.css">
<!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar/sidebar_style.css">
<link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" --> <!-- InstanceEndEditable -->
</head>
<div>
  <div id="wrapper">
    <div class="overlay"></div>
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
      <ul class="nav sidebar-nav">
        <li class="sidebar-brand"> <a href="#"> Epsilon </a> </li>
        <li> <a href="registrationFull.php"><i class="fa fa-fw fa-home"></i>התחבר</a> </li>
        <form class="navbar-form navbar-center" role="search" id="navBarSearchForm">
          <div class="form-group">
            <input type="text" id="Autocomplete1" class="form-control" placeholder="מצא/י קורסים" style="width:180px !important;">
          </div>
          <a href="coursePage.html">
          <button type="submit" class="btn btn-default" style="margin-top:5px;">חפש/י</button>
          </a>
        </form>
      </ul>
    </nav>
    <!-- /#sidebar-wrapper --> 
    
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <button type="button" class="hamburger is-closed animated fadeInRight" data-toggle="offcanvas"> <span class="hamb-top"></span> <span class="hamb-middle"></span> <span class="hamb-bottom"></span> </button>
    </div>
    <!-- /#page-content-wrapper --> 
    
  </div>
  <!-- InstanceBeginEditable name="body" -->
  <body id="index_body" style="width:100%; height:100%;" onload='loadCategories()'>
  <div style="float:right; width:40%; margin-right:35%">
    <div style="text-align:center;"> <img alt="logo" src="images/logo.png" 
      										style="margin-top:0%; width:100%; height:100%;"> </div>
  </div>
  <div style="float:right;
  			  width:20%; 
              height:100vh;
              margin-top:0%">
  <?php
        if (login_check($mysqli) == false) { ?>
    <div> <a  href="registrationFull.php"
            	style="margin-top:20px;" type="submit" class="button2" name="action" 
                id="upload_submit">התחברות/הרשמה</a> </div>
    <p class="or-divider italic" dir="rtl">או</p>
    <?php } else { ?>
    	    <div> <a  href="includes/logout.php"
            	style="margin-top:20px;" type="submit" class="button2" name="action" 
                id="upload_submit">התנתקות</a> </div>
            <p class="or-divider italic" dir="rtl">או</p>
    <?php } ?>
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
        <select id='course' style="margin-top:40px">
          <option value="" disabled selected>בחר/י קורס</option>
        </select>
        <input type="submit" class="button2" name="action" id="upload_submit" value="חיפוש" 
        	   style="margin-top:50px"/>
      </form>
      <?php
        if (login_check($mysqli) == true) { ?>
    	<p class="or-divider italic" dir="rtl">או</p>
    	<div> <a  href="createCourse.php"
            	type="submit" class="button2" name="action" 
                id="upload_submit">הוסף קורס חדש</a></div>
    	<?php } ?>
    </div>
  </div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
  <script src="js/upload_form/upload_form_index.js"></script>
  </body>
  <!-- InstanceEndEditable --> 
  <!-- /#wrapper --> 
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
  <script src="js/bootstrap.js"></script> 
  <script src="js/bootstrap.min.js"></script> 
  <script src="js/jquery-1.11.2.min.js"></script> 
</div>
<!-- InstanceEnd -->
</html>
