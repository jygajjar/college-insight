<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	//echo $_SESSION["TrackingURL"];
	Confirm_Login();

	if(isset($_POST["JoinClassButton"]))
	{
		if(!empty($_POST["classcode"]))
		{
			$ClassCode = $_POST["classcode"];
			$SId=$_SESSION["User_Id"];
			$CId=$_POST["classcode"];
			$Status="unapproved";

			if(CheckClassCodeValidOrNot($ClassCode))
			{
				if(!CheckUserNameExistsOrNotInClass($SId,$CId))
				{
					//getting teacher id
					global $ConnectingDB;
					$sql="SELECT tid FROM class where id='$_POST[classcode]'";
					$Execute=$ConnectingDB->query($sql);
					if($DataRows=$Execute->fetch()){
						$TId=$DataRows["tid"];
						$sql="INSERT INTO classroom(tid,cid,sid,status)";
						$sql.="VALUES(:tiD,:ciD,:siD,:staTus)";
						$stmt=$ConnectingDB->prepare($sql);
						$stmt->bindValue(':tiD',$TId);
						$stmt->bindValue(':ciD',$ClassCode);
						$stmt->bindValue(':siD',$SId);
						$stmt->bindValue(':staTus',$Status);
						$Execute=$stmt->execute();
						if($Execute)
						{
							$_SESSION["SuccessMessage"]="Class Joined requested . Class owner will approve you. ";
							Redirect_to("StudentDashboard.php");
						}
						else
						{
							$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
							Redirect_to("StudentDashboard.php");
						}
					}
					else
					{
	    				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
	    				Redirect_to("StudentDashboard.php");
	    			}
				}
				else
				{
					$_SESSION["ErrorMessage"]="Student Already Exist in Class !";
	      			Redirect_to("StudentDashboard.php");
				}
			}
			else
			{
				$_SESSION["ErrorMessage"]="Enter Valid Class Code !";
	      		Redirect_to("StudentDashboard.php");
			}
		}
		else
		{
			$_SESSION["ErrorMessage"]="Enter Class Code,if you dont have code ask your teacher";
      		Redirect_to("StudentDashboard.php");
		}	
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once("Includes/incFile.php");?>
	<title>Dashboard</title>
</head>
<body>
	
	<?php require_once("Includes/studentHeader.php");?>


  	<section class="container py-2 mb-4">
  		<div class="row">

  			<div class="col-lg-2  d-md-block" style="top:50px;">
  				<div class="card text-center bg-dark text-white mb-3">
  					<div class="card-body">
  						<h1 class="lead">Class</h1>
  						<h4 class="display-5">
  							<i class="fab fa-readme"></i>
  							<?php
  							TotalClassesForStudent();
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
  							TotalAssignmentForStudent();
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
  							TotalNotificationForStudent();
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
				<div class="row">

					<h1 class="h1 col-md-7 ml-4">Class</h1>
					<form class="form-inline d-sm-block" action="StudentDashboard.php" method="POST">
						<div class="form-group">
							<input class="form-control mr-2" type="text" name="classcode" placeholder="Enter Class Code" value="">
							<button class="btn btn-primary" type="submit" name="JoinClassButton" >Join New Class</button>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-8" >
						<?php
						global $ConnectingDB;
						$StdId=$_SESSION["User_Id"];
						$sql="SELECT c.id as cid, c.cname as cname ";
						$sql .=" FROM classroom as cr, class as c ";
						$sql .= " where cr.cid=c.id and cr.sid='$StdId' AND cr.status='approved' ORDER BY cr.id desc";
						$Execute=$ConnectingDB->query($sql);

						$classFound = false;
						while($DataRows=$Execute->fetch()){
							$ClassId=$DataRows["cid"];
							$ClassName=$DataRows["cname"];
							$classFound = true;
						?>

							<div class="col-md-8 offset-2 mb-3">
								<a href="ClassRoom.php?id=<?php echo $ClassId;?>&&action=details" class="btn btn-primary btn-lg btn-block">
									<i class=""></i><?php echo $ClassName;?>
								</a>
							</div>


								
							<?php
							}
							if(!$classFound){
								?>
								<div class="noClass">
									<p class="m-3 h1">Join New Class</p>
									<p class="m-3 h5">Start learning</p>
								</div>	
						<?php
							}
							?>
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
