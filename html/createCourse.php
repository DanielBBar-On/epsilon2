<?php

include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';

sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

?>

<!DOCTYPE html>
<html>
<!-- InstanceBegin template="/templates/sidebarAfterSignIn.dwt" codeOutsideHTMLIsLocked="false" -->
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
        <li> <a href="#"><i class="fa fa-fw fa-home"></i> דף הבית</a> </li>
        <li> <a href="#"><i class="fa fa-fw fa-folder"></i> על מנת להתחיל בשימוש, חפש קורס</a> </li>
        <form class="navbar-form navbar-center" role="search" id="navBarSearchForm">
          <style>
#navBarSearchForm input[type=text]   
</style>
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
<body id="index_body">
<div id="upload_body">
  <h1 id="upload_h1">הוספת קורס</h1>

<div id="upload_div">  
    <form action="php/upload_form/ajax.php" method="post" enctype="multipart/form-data">
    	<!-- user title -->
        <select name="faculty" id="faculty" placeholder="xx">
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

        <!-- first name -->
        <input type="upload_text" name="courseNum" id="courseNum" placeholder="מספר קורס"></input>

        <!-- last name -->
        <input type="upload_text" name="courseName" id="courseName" placeholder="שם הקורס"></input>

        <!-- message -->
        <textarea type="upload_text" placeholder="סילבוס"></textarea>

        <!-- <CTA></CTA> -->
        <input type="submit" class="button2" name="action" id="upload_submit" value="create" />
        <!-- <CTA></CTA> -->
        <input type="submit" class="button2" name="action" id="upload_submit" value="remove" />
        </form>
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