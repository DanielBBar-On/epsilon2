<?php
include_once '../includes/register.inc.php';
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/sidebarBeforeSignIn.dwt" codeOutsideHTMLIsLocked="false" -->
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
<link rel="stylesheet" href="css/registration/registration_style.css">
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
    <?php
        if (!empty($error_msg)) {
            echo "<h1> $error_msg </h1>";
        }
        ?>
    <ul class="tab-group">
      <li class="tab active"><a href="#signup">הרשמה</a></li>
      <li class="tab"><a href="#login">התחברות</a></li>
    </ul>
    <div class="tab-content">
      <div id="signup" dir="rtl">
        <h1 dir="rtl">דף הרשמה</h1>
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" 
                method="post" 
                name="registration_form">
          <!--	<div class="top-row">
          <div class="field-wrap" align="left">
            <label dir="rtl"> שם פרטי<span class="req" dir="rtl">*</span> </label>
            <input type="text" required autocomplete="off" dir="rtl" />
          </div>
          <div class="field-wrap" dir="rtl">
            <label > שם משפחה<span class="req">*</span> </label>
            <input type="text"required autocomplete="off"/>
          </div>
        </div>-->
          <div class="field-wrap">
            <label> שם משתמש<span class="req">*</span> </label>
            <input type="text" name='username' 
                id='username' required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label> דוא״ל<span class="req">*</span> </label>
            <input type="email" name="email" id="email" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label> סיסמה<span class="req">*</span> </label>
            <input type="password" name="password" 
                             id="password" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label> יהכנס סיסמא בשנית<span class="req">*</span> </label>
            <input  type="password" name="confirmpwd" 
          			id="confirmpwd"  required autocomplete="off"/>
          </div>
          <button type="submit" class="button button-block" value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);"/>
          הרשם
          </button>
        </form>
      </div>
      <div id="login">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
        <h1>ברוכים הבאים</h1>
        <form action="/includes/process_login.php" method="post" name="login_form">
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
