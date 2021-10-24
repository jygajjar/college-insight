<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");

  if(isset($_SESSION["UserEmail"])){
		Redirect_to("StudentDashboard.php");
	}

	if(isset($_POST["Submit"])){
		$FirstName=$_POST["firstname"];
		$LastName=$_POST["lastname"];
		$UserName=$_POST["email"];
		$Password=$_POST["tpass"];
		$Vkey=md5(date('m/d/Y h:i:s', time()));
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);


		if(empty($FirstName)&&empty($LastName)&&empty($UserName)&&empty($Password)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("Registration.php");
		}else{
			$Found_Account=Login_Attempt($UserName,$Password);
			if($Found_Account){
        $_SESSION["ErrorMessage"]="Email Already Exist!";
        Redirect_to("Registration.php");
			}else{
        AddStudent($FirstName,$LastName,$UserName,$Password,$Vkey,$DateTime);
		$_SESSION["SuccessMessage"]="Student Registered Successfully";
        Redirect_to("login.php");
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Student Registration</title>
</head>
<body class="home">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

		<div class="container">

			<a href="index.php" class="navbar-brand"><img src="Images/collegeinsight.png" height=60px></a>
			<div class="collapse navbar-collapse" id="navbarcollapseCMS">

			</div>
		</div>
	</nav>



	<section class="container py-2 mb-3">
		<div class="row">
			<div class="offset-sm-3 col-sm-6" style="min-height:430px;" >
			<br><br><br>
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
    ?>
				<div class="card bg-secondary text-light">
					<div class="card-header">
						<h4>Registeration</h4>
						</div>
							<div class="card-body bg-dark">
							<form class="" id="rform" action="Registration.php" method="post">
							
							<div class="form-group">
									<div class="input-group mb-3">
										<select name="role" id="role" class="form-select form-control" aria-label="Default select example">
											<option value="student" selected>Student</option>
											<option value="teacher">Teacher</option>
										</select>
									</div>
								</div>
								<div class="row">
                					<div class="col-md-6 form-group">
                							<input class="form-control form-control-lg" type="text" name="firstname" placeholder="First Name">
                					</div>
                					<div class="col-md-6 form-group">
                						<input class="form-control form-control-lg" type="text" name="lastname" placeholder="Surname">
                					</div>
                					</div>
                					<div class="form-group form-group-lg">
                							<input class="form-control form-control-lg" type="email" name="email"  placeholder="Email">
                					</div>
                					<div class="form-group  form-group-lg">
                							<input class="form-control form-control-lg" type="password" name="tpass" placeholder="Password">
                					</div>
									<span class="small">
									By clicking Sign Up, you agree to our <a href="term-and-conditions.php" target="_blank">Term and Condition</a>.
									</span>
                					<div class="row">
                						<div class="col-md-8">
                							<button type="submit" name="Submit" class="btn btn-success btn-lg btn-block">Sign up</button>
                						</div>
                						<div class="col-md-4">
                							<button type="Reset" class="btn btn-primary btn-lg btn-block">Reset</button>
                						</div>
                					</div>
                				</form><hr>
                				<div class="">
                						<span class="text-primary">Have you Already Account? </span>
                					<div class="form-group">
                						<div class="col-lg-12">
                							<a href="login.php" id="loginLink" class="btn btn-info btn-lg btn-block">Login</a>
                						</div>
                					</div>
                				</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</section>



	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
		$('#year').text(new Date().getFullYear());

		$('#role').change(function () {
			var optionSelected = $(this).find("option:selected");
			var role  = optionSelected.val();
			if(role == "teacher")
			{
				document.getElementById("rform").setAttribute("action","TeacherRegistration.php");
			}
			else
			{
				document.getElementById("rform").setAttribute("action","Registration.php");

			}
		});
	</script>
</body>
</html>
