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
<html><!-- InstanceBegin template="/templates/sidebarBeforeSignIn.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Epsilon</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/bootstrap.css">
<!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar/sidebar_style.css">
<link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" -->
<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/registration/login_style.css">
<script type="text/JavaScript" src="js/registration/sha512.js"></script> 
<script type="text/JavaScript" src="js/registration/forms.js"></script> 
<!-- InstanceEndEditable -->
</head>

<div>
  <div id="wrapper">
    <div class="overlay"></div>
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
      <ul class="nav sidebar-nav">
        <li class="sidebar-brand"> <a href="#"> Epsilon </a> </li>
        <li> <a href="registrationFull.php"><i class="fa fa-fw fa-home"></i>דף הבית</a></li>
        <li> <a href="registrationFull.php"><i class="fa fa-fw fa-sign-in"></i>התחבר</a> </li>
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
  <body id="index_body">
  <div class="form">
    <div class="tab-content">
      <div id="login">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
        <h1>ברוכים הבאים!</h1>
        <h1 dir="rtl" align="center">ההרשמה הושלמה בהצלחה. אנא הכניסו מייל וסיסמא על מנת להתחבר</h1>
        <form action="includes/process_login.php" method="post" name="login_form">
          <div class="field-wrap">
            <label dir="rtl"> אי מייל <span class="req">*</span> </label>
            <input type="text" name="email" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label> סיסמה<span class="req">*</span> </label>
            <input type="password" name="password" 
                             id="password" required autocomplete="off"/>
          </div>
          <p class="forgot"><a href="#">Forgot Password?</a></p>
          <button class="button button-block" type="button" 
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);"> התחבר </button>
          <?php	
        if (login_check($mysqli) == true) {
 						//Todo: do we want to add this cute little messages?
                        //echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
 
            //echo '<p>Do you want to change user? <a href="/includes/logout.php">Log out</a>.</p>';
        } else {
                        //echo '<p>Currently logged ' . $logged . '.</p>';
                        //echo "<p>If you don't have a login, please <a href='register.php'>register</a></p>";
                }
		?>
        </form>
      </div>
    </div>
    <!-- tab-content --> 
    
  </div>
  <!-- /form --> 
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
  <script src="js/registration/index.js"></script>
  </body>
  <!-- InstanceEndEditable --> 
  <!-- /#wrapper --> 
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
  <script src="js/bootstrap.js"></script> 
  <script src="js/bootstrap.min.js"></script> 
  <script src="js/jquery-1.11.2.min.js"></script> 
</div>
<!-- InstanceEnd --></html>
