<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//	Confirm_Login();

  if(isset($_GET['tid']))
  {
  	global $ConnectingDB;
  	$sql="SELECT * FROM teacher WHERE id='$_GET[tid]'";
  	$stmt=$ConnectingDB->query($sql);
  	while($DataRows=$stmt->fetch()){
  		$ExistingEmail=$DataRows['email'];
  		$ExistingFirstName=$DataRows['firstname'];
  		$ExistingLastName=$DataRows["lastname"];
  		$ExistingBio=$DataRows['bio'];
  		$ExistingImage=$DataRows["profilephoto"];
		$ExistingStatus="Teacher";
  	}
  }
  elseif(isset($_GET['sid']))
  {
  	global $ConnectingDB;
  	$sql="SELECT * FROM student WHERE id='$_GET[sid]'";
  	$stmt=$ConnectingDB->query($sql);
  	while($DataRows=$stmt->fetch()){
  		$ExistingEmail=$DataRows['email'];
  		$ExistingFirstName=$DataRows['firstname'];
  		$ExistingLastName=$DataRows["lastname"];
  		$ExistingBio=$DataRows['bio'];
  		$ExistingImage=$DataRows["profilephoto"];
		$ExistingStatus="Student";
  	}
  }
  else
  {
    $_SESSION["ErrorMessage"]="Bad Request!";
    Redirect_to("ClassRoom.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Profile</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

	<a href="index.php" class="navbar-brand"><img src="Images/collegeinsight.png" height=60px></a>
<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarcollapseCMS">
	<ul class="navbar-nav mr-auto">
				
			</ul>
	</div>
</div>
</nav>



	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<div class="card-header bg-dark text-light">
						<h3><?php echo $ExistingFirstName;?></h3>
					</div>
					<div class="card-body">
						<img src="Images/<?php echo $ExistingImage;?>" class="block img-fluid mb-3" name="">
						<div class="">
							<?php echo $ExistingBio;?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9" style="min-height:400px;">
				<form class="" action="#" method="post" id="" enctype="multipart/form-data">
					<div class="card bg-dark text-light">
						<div class="card-header bg-secondary text-light">
							<h4>Profile</h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group col-md-6">
									<input class="form-control" type="text" name="firstname" id="title" placeholder="Firstname" value="<?php echo $ExistingFirstName;?>" readonly>
								</div>
								<div class="form-group col-md-6">
									<input class="form-control" type="text" name="lastname" id="title" placeholder="Lastname" value="<?php echo $ExistingLastName;?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<input class="form-control" type="email" placeholder="Email" name="email" value="<?php echo $ExistingEmail;?>" readonly>
							</div>
							<div class="form-group">
								<textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80" readonly><?php echo $ExistingBio;?></textarea>
							</div>
<!--							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
							</div>
	-->					</div>
					</div>
				</form>
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
