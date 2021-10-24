<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	
	if(isset($_SESSION["admin_user"])){
		Redirect_to("adminDashboard.php");
	}

	
	if(isset($_POST["Submit"])){
		$UserName=$_POST["Username"];
		$Password=$_POST["Password"];

		if(empty($UserName)&&empty($Password)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("adminpanel.php");
		}else{

			$Found_Account= $UserName== 'admin' && $Password== 'admin';
			if($Found_Account){
				$_SESSION["admin_user"]=$UserName;
				Redirect_to("adminDashboard.php");
			}else{
				$_SESSION["ErrorMessage"]="Incurrect Username/Password";
				Redirect_to("adminpanel.php");
			}
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Admin Panel</title>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

		<div class="container">
      <a href="index.php" class="navbar-brand"><img src="Images/collegeinsight.png" width=150px height=80px></a>
			<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
				<span class="navbar-toggler-icon"></span>
			</button>
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
						<h4>Admin Login !</h4>
						</div>
							<div class="card-body bg-dark">
							<form class="" action="adminpanel.php" id="lform" method="post">

						
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
	</script>
</body>
</html>
