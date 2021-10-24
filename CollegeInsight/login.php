<!DOCTYPE html>
<html>
<head>
<?php 
	require_once("Includes/incFile.php");
	require_once("Includes/Sessions.php");
?>
	<title>Login</title>
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
						<h4>Welcome Back !</h4>
						</div>
							<div class="card-body bg-dark">
							<form class="" action="studentLogin.php" id="lform" method="post">

							<div class="form-group">
									<label for="role"><span class="FieldInfo">Role :</span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
										</div>
										<select name="role" id="role" class="form-select form-control" aria-label="Default select example">
											<option value="student" selected>Student</option>
											<option value="teacher">Teacher</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="username"><span class="FieldInfo">Username :</span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" name="Username" id="username" placeholder="Email">
									</div>
								</div>
								<div class="form-group">
									<label for="password"><span class="FieldInfo">Password :</span></label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
										</div>
										<input type="password" class="form-control" name="Password" id="password" placeholder="Password">
									</div>
								</div>
								<input type="submit" class="btn btn-info btn-block" name="Submit" value="Login">
							</form>

							<div class="">
									<span class="text-primary">Don't have you Account? </span>
								<div class="form-group">
									<div class="col-lg-12">
										<a href="Registration.php" id="registerLink" class="btn btn-danger btn-lg btn-block">Create Account</a>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<script>
		$('#year').text(new Date().getFullYear());
		
		$('#role').change(function () {
			var optionSelected = $(this).find("option:selected");
			var role  = optionSelected.val();
			if(role == "teacher")
			{
				document.getElementById("lform").setAttribute("action","TeacherLogin.php");
			}
			else
			{
				document.getElementById("lform").setAttribute("action","studentLogin.php");
			}
		});
		
	</script>
</body>
</html>
