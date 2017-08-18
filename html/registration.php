<?php
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
<html dir="rtl">
<head>
<meta charset="UTF-8">
<title>Sign-Up/Login Form</title>
<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/registration/style.css">
<script type="text/JavaScript" src="js/registration/sha512.js"></script>
<script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body>
<div class="form">
  <ul class="tab-group">
    <li class="tab active"><a href="#signup">הרשמה</a></li>
    <li class="tab"><a href="#login">התחברות</a></li>
  </ul>
  <div class="tab-content">
    <div id="signup" dir="rtl">
      <h1 dir="rtl">דף הרשמה</h1>
      <form action="/" method="post" dir="rtl">
        <div class="top-row" dir="rtl">
          <div class="field-wrap" align="left" dir="rtl">
            <label dir="rtl"> שם פרטי<span class="req" dir="rtl">*</span> </label>
            <input type="text" required autocomplete="off" dir="rtl" />
          </div>
          <div class="field-wrap" dir="rtl">
            <label > שם משפחה<span class="req">*</span> </label>
            <input type="text"required autocomplete="off"/>
          </div>
        </div>
        <div class="field-wrap">
          <label> שם משתמש<span class="req">*</span> </label>
          <input type="text"required autocomplete="off"/>
        </div>
        <div class="field-wrap">
          <label> דוא״ל<span class="req">*</span> </label>
          <input type="email"required autocomplete="off"/>
        </div>
        <div class="field-wrap">
          <label> סיסמה<span class="req">*</span> </label>
          <input type="password"required autocomplete="off"/>
        </div>
        <button type="submit" class="button button-block"/>
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
                        echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
 
            echo '<p>Do you want to change user? <a href="/includes/logout.php">Log out</a>.</p>';
        } else {
                        echo '<p>Currently logged ' . $logged . '.</p>';
                        echo "<p>If you don't have a login, please <a href='register.php'>register</a></p>";
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
</html>
