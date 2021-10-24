<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Teacher_Login();

	if(isset($_POST["Submit"])){
		global $ConnectingDB;

		$StudentEmail=$_POST["semail"];
		$CId=$_POST["classid"];
		$TId=$_SESSION["Teacher_Id"];
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

		$sql2="SELECT * FROM student WHERE email='$StudentEmail'";
		$stmt=$ConnectingDB->query($sql2);
		while($DataRows=$stmt->fetch()){
			$SId=$DataRows["id"];
		}
		if($SId==null){
			$_SESSION["ErrorMessage"]="Student Do not have account.";
			Redirect_to("AddStudentToClass.php");
		}


		if(empty($StudentEmail) || empty($SId)){
			$_SESSION["ErrorMessage"]="Email can not be Empty";
			Redirect_to("AddStudentToClass.php");
		}
    elseif(CheckUserNameExistsOrNotInClass($SId,$CId,$TId))
    {
      $_SESSION["ErrorMessage"]="Student Already Exist in Class !";
      Redirect_to("AddStudentToClass.php");
		}
    else {
    			$sql="INSERT INTO classroom(tid,cid,sid,status)";
    			$sql.="VALUES(:tnaMe,:cnaMe,:sEmail,:staTus)";
    			$stmt=$ConnectingDB->prepare($sql);
    			$stmt->bindValue(':tnaMe',$TId);
          $stmt->bindValue(':cnaMe',$CId);
    			$stmt->bindValue(':sEmail',$SId);
    			$stmt->bindValue(':staTus','approved');
    			$Execute=$stmt->execute();
    			if($Execute){
    				$_SESSION["SuccessMessage"]="Student Added Successfully";
    				Redirect_to("AddStudentToClass.php");
    			}else{
    				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
    				Redirect_to("AddStudentToClass.php");
    			}

    }

	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Add Student</title>
</head>
<body>
<?php require_once("Includes/header.php");?>


	<header class=" py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Add New Student</h1>
				</div>
			</div>
		</div>
	</header>



	<section class="container py-2 mb-4">
		<div class="row">
			<div class="offset-lg-1 col-lg-10" style="min-height:400px;">
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
				<form class="" action="AddStudentToClass.php" method="post" id="" enctype="multipart/form-data">
					<div class="card  mb-3">
						<div class="card-body">
              <div class="form-group">
								<label for="SEmail"><span class="FieldInfo">Student Email :</span></label>
								<input class="form-control" id="SEmail" type="text" name="semail" placeholder="Enter Student Email">
							</div>
							<div class="form-group">
								<label for="ClassName"><span class="FieldInfo">Choose Class:</span></label>
								<select class="form-control" id="ClassName" name="classid">
									<?php
										global $ConnectingDB;
										$dataFound = false;
										$sql="SELECT id,cname FROM class WHERE tid=$_SESSION[Teacher_Id]";
										$stmt=$ConnectingDB->query($sql);
										while($DataRows=$stmt->fetch()){
											$dataFound = true;
											$Id=$DataRows["id"];
											$ClassName=$DataRows["cname"];
											echo "<option value='".$Id."'>".$ClassName."</option>";
										}
										
										if(!$dataFound){
											?>
											<option disabled>Empty Class</option>
									<?php
										}
									?>
								</select>
							</div>
              <div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Add Student
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
