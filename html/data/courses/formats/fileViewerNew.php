<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Epsilon</title>

<link rel="stylesheet" href="../../../css/bootstrap.css">
<!<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../../../css/sidebar/sidebar_style.css">
<link href="../../../css/flat_ui.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../../css/pdf_viewer/pdf_viewer_style.css">
<link rel="stylesheet" href="../../../css/show_hide_button/show_hide_style.css">
<link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="../../../css/forum/forum_style.css">

</head>

<body id="index_body" style="margin-top:5%;">
<div class="row">
  <div class="col-md-6" id="content">
<div id="target">

  	<!-- responsive iframe --> 
<!-- ============== -->
<div id="Iframe-Cicis-Menu-To-Go-Answer" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
  <div class="responsive-wrapper 
     responsive-wrapper-padding-bottom-90pct"
     style="-webkit-overflow-scrolling: touch; overflow: auto;">
    <iframe src="http://webcourse.cs.technion.ac.il/236334/Spring2017/ho/WCFiles/Winter16-17%20B.pdf">
    <p style="font-size: 110%;"><em><strong>ERROR: </strong> An &#105;frame should be displayed here but your browser version does not support &#105;frames.</em> Please update your browser to its most recent version and try again, or access the file <a href="https://drive.google.com/file/d/0BxrMaW3xINrsR3h2cWx0OUlwRms/preview"></a></p>
    </iframe>
  </div>
</div>
</div>
</div>
<div class="col-md-12" id="question" style="float:right;" align="center">
  <script type="text/javascript">
    function hasClass(ele,cls) {
     return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
	}
	
	function changeClass()
    {
		if(hasClass(document.getElementById("question"), "col-md-6")){
			document.getElementById("question").className = "col-md-12";
		} else {
			document.getElementById("question").className = "col-md-6";	
		}
    }
</script>
  <!-- responsive iframe -->
  <!-- ============== -->
  <div id="Iframe-Cicis-Menu-To-Go-Question" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
    <div class="responsive-wrapper 
     responsive-wrapper-padding-bottom-90pct"
     style="-webkit-overflow-scrolling: touch; overflow: auto;">
      <iframe src="http://webcourse.cs.technion.ac.il/236334/Spring2017/ho/WCFiles/Winter16-17%20B.pdf">
      <p style="font-size: 110%;"><em><strong>ERROR: </strong> An &#105;frame should be displayed here but your brow	ser version does not support &#105;frames.</em> Please update your browser to its most recent version and try again, or access the file <a href="https://drive.google.com/file/d/0BxrMaW3xINrsR3h2cWx0OUlwRms/preview"></a></p>
      </iframe>
    </div>
  </div>
  <button class="btn btn-default2 Show" id="hideshow" value="hide/show" onClick="changeClass()">הצג פתרון</button>
  <button class="btn btn-default2 Hide" id="hideshow"value="hide/show" onClick="changeClass()" style="display:none;">הסתר פתרון</button>
</div>
</div>
</div>

<div style="text-align:center;">
	<textarea id="questionText" type="ask_question" placeholder="שאל שאלה"></textarea>
    <br>
    <input type="submit" class="button2" name="action" id="upload_submit" value="ask" onClick="askQuestion()"/>
        <input type="submit" class="button2" name="saveForum" id="saveForum" value="saveForum" onClick="saveForum();"/>
</div>
<div class="vue-wrapper">
	<div id="vue">
		<div class="search-area">
			<h1>דיונים</h1>
				<div class="input-wrapper"> <i class="fa fa-search"></i>
					<input v-model="searchString" type="text" placeholder="Have a question? Search for answers with keywords"/>
				</div>
				<button @click="resetSearch()">נקה</button>
			</div>
            
            <div id="questions">
            </div>
	</div>
</div>
            
          
            
			<!--<div class="question" v-for="question in questions | filterBy searchString" track-by="$index" data-color="{{ question.votes | voteColor }}">
			<div class="votes">
				<div class="upvote" @click="vote('up', question)">
                </div>
				<div class="number-of-votes">{{ question.votes }}
                </div>
				<div class="downvote" @click="vote('down', question)">
                </div>
			</div>
			<div class="question-and-answer">
				<h2 style="color: #000000; direction: rtl;">{{ question.question }}</h2>
					<p style="color: #000000; direction: rtl">{{ question.answer }}</p>
			</div>
		</div>-->
 <!--<div class="forum_container">
 <iframe src="http://ec2-52-11-111-48.us-west-2.compute.amazonaws.com:8000/" 
 frameborder="0" allowfullscreen class="forum"></iframe>
 </div>-->
</body>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="../../../js/show_hide_button/show_hide_button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.js"></script>
<script src="../../../js/forum/forum_self.js"></script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="../../../js/bootstrap.js"></script>
<script src="../../../js/bootstrap.min.js"></script>
<script src="../../../js/jquery-1.11.2.min.js"></script>
</html>