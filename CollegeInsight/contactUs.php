<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");

	if(isset($_POST["Submit"])){
		$Name=$_POST["CommenterName"];
		$Email=$_POST["CommenterEmail"];
		$Description=$_POST["Description"];
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);

		if(empty($Name)&&empty($Email)&&empty($Description)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("contactUs.php");
		}else{
			$sql="INSERT INTO contactus (fullname,email,description,datetime,status)";
			$sql.="VALUES(:fullName,:emaIl,:descripTion,:daTetime,:staTus)";
			$stmt=$ConnectingDB->prepare($sql);
			$stmt->bindValue(':fullName',$Name);
			$stmt->bindValue(':emaIl',$Email);
			$stmt->bindValue(':descripTion',$Description);
			$stmt->bindValue(':daTetime',$DateTime);
			$stmt->bindValue(':staTus','pending');
			$Execute=$stmt->execute();
			
			if($Execute){
				$_SESSION["SuccessMessage"]="Details Added Successfully";
				Redirect_to("contactUs.php");
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
				Redirect_to("contactUs.php");
			}
		}
	}	
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>CollegeInsight | Contact us</title>
    
</head>
<body class="home">
	<nav class="navbar navbar-expand-lg bg-dark">

		<div class="container">

			<a href="index.php" class="navbar-brand"><img src="Images/collegeinsight.png" height=60px></a>
			<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarcollapseCMS">
			<ul class="navbar-nav mr-auto">
				
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item"><a href="login.php" class="btn btn-success">Login</a></li>
			</ul>
            <ul class="navbar-nav">
				<li class="nav-item"><a href="contactUs.php" class="btn btn-info ml-2">Contact us</a></li>
			</ul>
			</div>
		</div>
	</nav>

    <div class="container-fluid row">
        <div class="col-5 offset-1 mt-4 text-white" style="text-shadow: -1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000,1px 1px 0 #000">
            <h2>Developer Contact:</h2>
            <h1>Ketan Chavda</h1>
            <h3>Student at GEC rajkot</h3>
            <h3>9876543210</h3>
            <h3 >collegeinsight.ketan@gmail.com</h3>
</div>
<div class="col-5 offset-1 mt-4">
<?php
      echo ErrorMessage();
      echo SuccessMessage();
    ?>
    <p style="color:white;">*fill form and we will contact you very soon</p>
<form class="" action="contactUs.php" method="post">
					<div class="card mb-3">
						<div class="card-header">
							<h5 class="FieldInfo">Contact us</h5>
						</div>
						<div class="card-body">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input class="form-control" type="text" name="CommenterName" placeholder="Your Name" value="">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-envelope"></i></span>
									</div>
									<input class="form-control" type="email" name="CommenterEmail" placeholder="Your Email" value="">
								</div>
							</div>
							<div class="form-group">
								<textarea class="form-control" name="Description" rows="6" cols="80" placeholder="Description"></textarea>
							</div>
							<div class="">
								<button class="btn btn-primary" type="submit" name="Submit">Submit</button>
							</div>
						</div>
					</div>
				</form>
</div>
</div>
  


	<script>
		$('#year').text(new Date().getFullYear());
		
	</script>
</body>
</html>
