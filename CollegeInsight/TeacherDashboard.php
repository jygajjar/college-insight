<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	//echo $_SESSION["TrackingURL"];
	Confirm_Teacher_Login();
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Teacher Dashboard</title>
</head>
<body>

	<?php require_once("Includes/header.php");?>


  	<section class="container py-2 mb-4">
  		<div class="row">


  			<div class="col-lg-2  d-md-block">
  				<div class="card text-center bg-dark text-white mb-3">
  					<div class="card-body">
  						<h1 class="lead">Class</h1>
  						<h4 class="display-5">
  							<i class="fab fa-readme"></i>
  							<?php
  							TotalClasses();
  							?>
  						</h4>
  					</div>
  				</div>

  				<div class="card text-center bg-dark text-white mb-3">
  					<div class="card-body">
  						<h1 class="lead">Assignment</h1>
  						<h4 class="display-5">
  							<i class="fas fa-folder"></i>
  							<?php
  							TotalAssignment();
  							?>
  						</h4>
  					</div>
  				</div>


  				<div class="card text-center bg-dark text-white mb-3">
  					<div class="card-body">
  						<h1 class="lead">Notification</h1>
  						<h4 class="display-5">
  							<i class="fas fa-users"></i>
  							<?php
  							TotalNotification();
  							?>
  						</h4>
  					</div>
  				</div>
  		</div>
			<div class="col-lg-10" style="top:50px;">

				 <div class="col-md-6">
							<?php
									echo ErrorMessage();
									echo SuccessMessage();
								?>
				</div>
				<?php
				global $ConnectingDB;
				$sql="SELECT * FROM class where tid=$_SESSION[Teacher_Id] ORDER BY id desc";
				$Execute=$ConnectingDB->query($sql);
				$SrNo=0;

				$dataFound = false;
				while($DataRows=$Execute->fetch()){
					$ClassId=$DataRows["id"];
					$ClassDate=$DataRows["datetime"];
					$ClassName=$DataRows["cname"];
					$CreatorName=$DataRows["tid"];
					$SrNo++;
					$dataFound = true;
					
				?>
				
				<div class="col-md-8 offset-2 mb-3">
					<a href="http://localhost/collegeinsight/TeacherClass.php?cid=<?php echo $ClassId;?>&&action=classDetails" class="btn btn-primary btn-lg btn-block">
						<i class=""></i><?php echo $ClassName;?>
					</a>
				</div>
				
				<?php } 
				
				if(!$dataFound){
					?>
					<a class="btn btn-success" style="float:right;" href="AddNewClass.php">Create Class</a>
					<div class="noClass">
						<p class="m-3">No Class Found</p>
					</div>	
			<?php
				}
				?>
				
				
				
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
