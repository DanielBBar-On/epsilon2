<?php

include_once '../includes/courses/functions.php';
include_once '../includes/secure_login/db_connect.php';
include_once '../includes/secure_login/functions.php';

define("FILE_TYPE", "summary");

	// login functions
	sec_session_start();
	
	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		header("registrationFull.php");
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
<link rel="stylesheet" href="css/bootstrap.css">
<!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sidebar/sidebar_style.css">
<link href="css/flat_ui.min.css" rel="stylesheet" type="text/css">

<!-- Javascripts --> 
<script type='text/javascript'>
      <?php
        echo "var categories = $jsonCats; \n";
        echo "var subcatsNum = $jsonsubcatsNum; \n";
		echo "var subcatsName = $jsonsubcatsName; \n";
      ?>
	
	function getYear() {
		var max = new Date().getFullYear(),
    	min = max - 25,
    	yearSelect = document.getElementById('year');
		yearSelect.options.length = 0;
		yearSelect.options[0] = new Option('בחר/י שנה');
		j = yearSelect.options.length;
		for (var i = max; i>=min; i--){
			yearSelect.options[j] = new Option(i);
			j++;
		}
	}
		
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
</head>

<body id="index_body" onLoad="loadCategories(); getYear()" onLoad="getYear()">
<div id="upload_body">
  <h1 id="upload_h1">העלאת סיכום</h1>
  
  <div id="upload_div">  
    <form action="php/upload_form/ajax.php" method="post" enctype="multipart/form-data">
      <!-- user title -->
      <select name="faculty" id="faculty">
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
        
        <select id='course'  name="courseNum">
          <option value="" disabled selected>בחר/י קורס</option>
        </select>
      
      <!-- file num -->
      <input type="upload_text" name="<?php echo FILE_TYPE ?>Num" id="num" placeholder="שבוע מספר"></input>
      
      <!-- file num -->
      <input type="upload_text" name="<?php echo FILE_TYPE ?>Name" id="num" placeholder="נושא ההרצאה"></input>
      
      <!-- year -->
      <select id="year" name="year"></select>
      
		<select name="semester" id="semester">
        	<option value="" disabled selected>בחר/י סמסטר</option>
			<option value='winter'	>חורף</option>
			<option value="spring"	>אביב</option>
            <option value="summer"	>קיץ</option>
		</select>
      <!-- message -->
      <textarea type="upload_text" placeholder="הערות"></textarea>
      
      <input type="hidden" name="id" value= <?php echo '"' . $_SESSION['user_id'] . '"' ?> >
      <input type="hidden" name="type" value="summaries">
      
      <!-- <CTA></CTA> -->
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" class="button2" name="action" id="upload_submit" value="upload"/>
      </form>

  </div>
  
</div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/upload_form/upload_form_index.js"></script>
</body>
  <!-- /#wrapper --> 
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
  <script src="js/bootstrap.js"></script> 
  <script src="js/bootstrap.min.js"></script> 
  <script src="js/jquery-1.11.2.min.js"></script> 
</div>
</html>
