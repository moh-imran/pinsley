<!DOCTYPE HTML>
	<!--
		Alpha by HTML5 UP
		html5up.net | @ajlkn
		Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
	-->
	<html>

	<head>
		<title>Phone Add-in For XLS</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

	<style>
	     #progressMessage
	 {
	    position:absolute;
	    top:70%;
	    left:0;
	    right:0;
	    width:300px;
	    z-index:3000;
	    margin: 0 auto;
	 }

	 #activityIndicator 
	 {
	   height: 32px;
	   width: 32px;
	   -webkit-background-size: 32px 32px;
	   -o-background-size: 32px 32px;
	   -moz-background-size: 32px 32px;
	   background-size: 32px 32px;
	   margin: 0px auto;
	   background-image: url("images/loader.gif");
	   background-color: transparent; 
	}
	</style> 

	</head>

	<body>
		<div id="page-wrapper">
			<!-- Header -->
			<header id="header">
				<h1 style="color: white; font-size: 24px;">Phone Add-in For XLS</h1>
				<nav id="nav">
					<ul>
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="upload.php">Upload File</a></li>
					</ul>
				</nav>
			</header>
			<!-- Main -->
			<section id="main" class="container">
				<div class="row">
					<div class="12u">
					
						<!-- Form -->
						<section class="box">
						<h3>Loaded File :</h3>						
						<i class="fa fa-file-excel-o" aria-hidden="true"> <?php echo $_COOKIE['file']; ?> </i>
					    
						<br>
						<br>
							<h3>Phone Number Add In</h3>
							<form id="process_phone">
								<input type="hidden" name="field_check" id="field_check">
								<div class="row uniform 50%">
									<div class="4u 12u(narrower)">
										<input type="radio" id="separate_cols" name="priority" checked>
										<label for="separate_cols">First Name and Last Name in separate cells.</label>
									</div>
									<div class="4u 12u(narrower)">
										<input type="radio" id="same_cols" name="priority">
										<label for="same_cols">First Name and Last Name in same cells.</label>
									</div>
								</div>

								<br>
								<h3>Choose Input Columns</h3>

								<div class="row uniform 50%">
									<div class="12u 12u(mobilep)">
										<input type="text" pattern="[A-Za-z]{1}"  name="fullName" id="fullName" value="" placeholder="Full Name" />
									</div>

								</div>
								<div class="row uniform 50%">
									<div class="6u 12u(mobilep)">
										<input type="text" pattern="[A-Za-z]{1}"  name="fname" id="fname" value="" placeholder="First Name" />
									</div>
									<div class="6u 12u(mobilep)">
										<input type="text" pattern="[A-Za-z]{1}" name="lname" id="lname" value="" placeholder="Last Name" />
									</div>
								</div>
								<div class="row uniform 50%">
									<div class="6u 12u(mobilep)">
										<input type="text" pattern="[A-Za-z]{1}"  name="state" id="state" value="" placeholder="State" />
									</div>
									<div class="6u 12u(mobilep)">
										<input type="text" pattern="[A-Za-z]{1}"  name="zip" id="zip" value="" placeholder="Zip" />
									</div>
								</div>

								<br>
								<h3>Choose Output Columns</h3>

								<div class="row uniform 50%">
									<div class="12u 12u(mobilep)">
										<input type="text" pattern="[A-Za-z]{1}"  name="phone" id="phone" value="" placeholder="Phone" />
									</div>

								</div>

								<div class="row uniform">
									<div class="12u">
										<ul class="actions">
											<li>
												<input id="submit_btn" type="button" value="Run" />
											</li>
											<li>
												<input type="reset" id="reset" value="Reset" class="alt" />
											</li>
										</ul>
									</div>
								</div>
							</form>
							<hr />

						</section>
					</div>
				</div>
			</section>
		</div>

	<div class="modal fade in" id="myModal" role="dialog" style="display: none; padding-left: 17px;">
        <div id="progressMessage" class="modal-dialog"  style=" padding:5px; box-shadow: 0 0 10px #999; background: #f5f5f5; border-radius: 7px; padding-top: 20px; text-align: center">
        <div id="activityIndicator">&nbsp;</div>
        <h3 style="font:bold; display:block; padding:5px; text-align: centre;"
             id="progressMessageLbl">Processing</h3>
             <p id="records"><b><strong id="record_val"></strong></b>  Records have been processed.</p> 
             
        </div>
    </div>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.dropotron.min.js"></script>
		<script src="assets/js/jquery.scrollgress.min.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/util.js"></script>
		<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
		<script src="assets/js/main.js"></script>
		<script type="text/javascript">

			$(document).ready(function() {

				/// for processing file
				var page_no = 1;
		        
				$("#fullName").hide();
				$("#field_check").val('separate_cols');
				$('input[type=radio][name=priority]').change(function(event) {
					
					console.log('data', this.id);
					if(this.id == 'separate_cols'){
						$("#field_check").val('separate_cols');
						$("#fullName").hide();
						$("#fname").show();
						$("#lname").show();					
					}
					else if(this.id == 'same_cols'){

						$("#field_check").val('same_cols');
						$("#fullName").show();
						$("#fname").hide();
						$("#lname").hide();
					}
				});

				$("#reset").click(function(event) {
					
					$("#process_phone").reset();
				});

				$("#submit_btn").click(function(event) {
					
					if ($("#field_check").val() == 'same_cols') {

						if($("#fullName").val() == '' || $("#phone").val() == ''){

							alert("Full Name and Phone are required.");
						}
						else
						{
							process_file(page_no);
						}
					}
					else if ($("#field_check").val() == 'separate_cols') {

						if($("#fname").val() == '' || $("#lname").val() == '' || $("#phone").val() == ''){

							alert("FirstName, LastName and Phone are required.");
						}
						else
						{
							process_file(page_no);
						}
					}	

					
							
		  
		});

		function process_file(page_no){

			$("#myModal").show();	
			$("#process_phone input").prop("disabled", true);
			
			if (page_no == 1) {$("#records").hide();}

			var $request = $.ajax({
			  type: "POST",
			  url: "processing.php",
			 data: "field_check=" + $("#field_check").val() + "&fullName=" + $("#fullName").val() + "&fname="+$("#fname").val()+ "&lname="+$("#lname").val() + "&state="+$("#state").val()+ "&zip="+$("#zip").val()+ "&phone="+$("#phone").val()+ "&page_no="+page_no,
			  
			  success: function(response) {			  
				  

			  		console.log('data', JSON.parse(response));
			  		var resp = JSON.parse(response);
			  		
			  		$("#records").show();
			  		$("#record_val").text(15 * parseInt(resp.page_no));

			  		if (resp.page_no <= resp.total_pages) {
			  			
			  			page_no = parseInt(resp.page_no) + 1;
			  			
			  			console.log('check page', page_no);
			  			

			  			//$( document ).ajaxStop(function() {
						    $request.abort();
							setTimeout(function(){ process_file(page_no); }, 2000);
						//}); 

				  }
				  else{
				  	
				  	$("#myModal").hide();
					$("#process_phone input").prop("disabled", false);

					
					location.href = 'download_file.php';
					// $.ajax({
					// 	  type: "POST",
					// 	  url: "download_file.php",
					// 	  data: '',						  
					// 	  success: function(html) {			  
							  
					// 	  }
					// });

				  }
			  		//return response;
			  }
		  	
		  	});
		}		

				

			});

		</script>>
	</body>


	</html>
