<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["TrackingURL"];
  Confirm_Teacher_Login();


  //updating new data
  if(isset($_POST["Submit"])){
	$notification=$_POST["notification"];
	$ClassId=$_POST["classid"];
	$aId=$_POST["aId"];
	date_default_timezone_set("Asia/Kolkata");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);


	if(empty($ClassId)){
		$_SESSION["ErrorMessage"]="Classname can not be Empty";
		Redirect_to("TeacherNotification.php");
	}elseif(strlen($Notification)>9999){
		$_SESSION["ErrorMessage"]="Notification should be less than 10000 characters";
		Redirect_to("TeacherNotification.php");
	}else{
		$sql="UPDATE notification SET cid='$ClassId', textcontent='$notification', datetime='$DateTime' WHERE id='$aId'";
		$stmt=$ConnectingDB->query($sql);
		$Execute=$stmt->execute();

		

		if($Execute){
			$_SESSION["SuccessMessage"]="Assignment updated Successfully";
			Redirect_to("TeacherNotification.php");
		}else{
			$_SESSION["ErrorMessage"]="1Something went wrong.Try Again !";
			Redirect_to("EditAssignment.php");
		}


	}

}






	//getting old data
	if(isset($_GET["id"])){
		$aId=$_GET["id"];
		global $ConnectingDB;
		$sql="SELECT * FROM notification WHERE id='$aId'";
		$Execute=$ConnectingDB->query($sql);
		$DataRows=$Execute->fetch();

		if($Execute){
			$Description = $DataRows['textcontent'];
			$Cid = $DataRows['cid'];
			$nid = $DataRows['id'];
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("TeacherAssignment.php");
		}
	}else{
		Redirect_to("TeacherAssignment.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Edit Notification</title>
</head>
<body>
<?php require_once("Includes/header.php");?>
	

	<section class="container py-2 mb-4" style="margin-top:20px;">
		<div class="row">
			<div class="offset-lg-1 col-lg-10" style="min-height:400px;">
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
				<form class="" action="EditNotification.php" method="post" id="" enctype="multipart/form-data">
					<div class="card  mb-3">
						<div class="card-header">
							<h1>Edit Notification</h1>
						</div>
						<div class="card-body ">
							<div class="form-group">
								<label for="ClassTitle"><span class="FieldInfo">Choose Class:</span></label>
								<select class="form-control" id="ClassTitle" name="classid">
									<?php
										global $ConnectingDB;
										$sql="SELECT id,cname FROM class Where tid='$_SESSION[Teacher_Id]'";
										$stmt=$ConnectingDB->query($sql);
										while($DataRows=$stmt->fetch()){
											$Id=$DataRows["id"];
											$ClassName=$DataRows["cname"];
											
											if($Cid == $Id){
												echo "<option value='".$Id."' selected>".$ClassName."</option>";
											}else{
												echo "<option value='".$Id."'>".$ClassName."</option>";
											}
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="Post"><span class="FieldInfo">Notification:</span></label>
								<textarea class="form-control" id="Post" name="notification" rows="8" cols="80"><?php echo $Description?></textarea>
							</div>
							<input class="form-control" type="text" name="aId" value="<?php echo $aId;?>" hidden>
							
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Update Notification
									</button>
								</div>
							</div>
						</div>
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
