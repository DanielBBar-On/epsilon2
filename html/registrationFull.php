<?php
include_once '../includes/register.inc.php';
include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';
 
sec_session_start();

if (login_check($loginsqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Epsilon</title>
<link rel="stylesheet" href="css/bootstrap.css">
<!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar/sidebar_style.css">
<link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/registration/registration_style.css">
</head>

<body id="index_body">
	<!-- icons -->
    <div style="width: 100%;
			text-align:center;">
	<span class="container-fluid" style="float:left;
                					margin-top:5px;">
        <a  href="index.php">
        <img src="images/logo-white.png" style="width:39.5px;
        									height:auto;
                                            padding:10px;">
                                            </a>
			<p style="color:#FCFCFC;">דף הבית</p>
            </span>
	<?php
        if (login_check($loginsqli) == false) { ?>
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
        if (login_check($loginsqli) == true) { ?>
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
        if (login_check($loginsqli) == true) { ?>
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
  <!-- icons end -->
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
            <label>הכנס/י סיסמא בשנית<span class="req">*</span> </label>
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
          <p class="forgot"><a href="#">שכחתי סיסמא</a></p>
          <button class="button button-block" type="button" 
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);"> התחבר </button>
          <?php
        if (login_check($loginsqli) == true) {
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
    </body>
  <!-- /form --> 
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
  <script src="js/registration/index.js"></script>
  <!-- /#wrapper --> 
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
  <script src="js/bootstrap.js"></script> 
  <script src="js/bootstrap.min.js"></script> 
  <script src="js/jquery-1.11.2.min.js"></script> 
  
  <script src="js/registration/forms.js"></script>
  <script src="js/registration/sha512.js"></script>
</html>