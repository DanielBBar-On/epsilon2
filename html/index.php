<?php

include_once '../includes/courses/functions.php';
?>

<!DOCTYPE html>
<html>
<!-- InstanceBegin template="/templates/sidebarBeforeSignIn.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Epsilon</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/upload_form/upload_form_style.css">
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
  <body id="index_body" style="width:100%; height:100%;">
    <div style="float:left; width:40%;">
      <div style="text-align:center;"> <img alt="logo" src="images/logo.png" 
      										style="margin-top:0%; width:100%; height:100%;"> </div>
    </div>
    <div style="float:left; width:20%; height:100vh; margin:auto;">
      <div id="upload_div" style="height:inherit;">
        <form action="php/upload_form/ajax.php" method="post" enctype="multipart/form-data" 
        				style="height:inherit; text-align:center; margin-top:70%; width:100%; height:100%;">
          <!-- user title -->
          <select>
            <option value="">בחר/י פקולטה</option>
            <option>הפקולטה להנדסה אזרחית וסביבתית</option>
            <option>הפקולטה להנדסת מכונות</option>
            <option>הפקולטה להנדסת חשמל</option>
            <option>הפקולטה להנדסה כימית</option>
            <option>הפקולטה להנדסת מזון וביוטכנולוגיה</option>
            <option>הפקולטה להנדסת אוירונוטיקה וחלל</option>
            <option>הפקולטה להנדסת תעשיה וניהול</option>
            <option>הפקולטה למתמטיקה</option>
            <option>הפקולטה לפיזיקה</option>
            <option>הפקולטה לכימיה</option>
            <option>הפקולטה לביולוגיה</option>
            <option>הפקולטה לארכיטקטורה ובינוי ערים</option>
            <option>הפקולטה לחינוך למדע וטכנולוגיה</option>
            <option>הפקולטה למדעי המחשב</option>
            <option>הפקולטה לרפואה</option>
            <option>הפקוטה למדע והנדסה של חומרים</option>
            <option>המחלקה ללימודים הומניסטיים ואמנויות</option>
            <option>הפקולטה להנדסה ביורפואית</option>
          </select>
          <br>
          
                    <!-- user title -->
          <!--style for select is in the select function-->
          <?=   select('courses', $_POST['courses'] ?? 'default value',
    				datasource(
						new mysqli(constant("HOST"), constant("USER"), constant("PASSWORD"), constant("DATABASE")), 
						"SELECT num FROM courses", "num"),
					datasource(
						new mysqli(constant("HOST"), constant("USER"), constant("PASSWORD"), constant("DATABASE")), 
						"SELECT name FROM courses", "name"));
				?>

          </select>
          <br>
          
          <input style="margin-top:50px" type="submit" class="button2" name="action" id="upload_submit" value="create" />
        </form><br>
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
