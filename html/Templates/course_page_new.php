<?php

include_once '../../../../includes/courses/functions.php';
include_once '../../../../includes/secure_login/db_connect.php';
include_once '../../../../includes/secure_login/functions.php';

	// login functions
	sec_session_start();

	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		$logged = 'out';
	}
?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/sidebarInCourseFolder.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Epsilon</title>
<link rel="stylesheet" href="../../../css/bootstrap.css">
<link rel="stylesheet" href="../../../css/sidebar/sidebar_style.css">
<link href="../../../css/flat_ui.min.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
          <a href="../coursePage.html">
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
  
  </body>
  
  <script src="../../../js/bootstrap.js"></script> 
  <script src="../../../js/bootstrap.min.js"></script> 
  <script src="../../../js/jquery-1.11.2.min.js"></script> 
  <!-- InstanceEndEditable --> 
  <!-- /#wrapper --> 
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
</div>
<!-- InstanceEnd --></html>
