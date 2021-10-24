<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Teacher_Login();

	if(isset($_POST["Submit"])){
		$ClassId=$_POST["cid"];
		$ClassName=$_POST["classname"];
		$TeacherId=$_SESSION["Teacher_Id"];
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

		if(empty($ClassName)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("AddNewClass.php");
		}elseif(strlen($ClassName)<3){
			$_SESSION["ErrorMessage"]="Class Title should be greater than 2 characters";
			Redirect_to("AddNewClass.php");
		}elseif(strlen($ClassName)>29){
			$_SESSION["ErrorMessage"]="Class Title should be less than 30 characters";
			Redirect_to("AddNewClass.php");
		}else{

			$sql="UPDATE class SET tid='$TeacherId', cname='$ClassName', datetime='$DateTime' WHERE id='$ClassId'";
			$stmt=$ConnectingDB->query($sql);
			$Execute=$stmt->execute();

			

			if($Execute){
				$_SESSION["SuccessMessage"]="Class updated Successfully";
				Redirect_to("AddNewClass.php");
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
				Redirect_to("AddNewClass.php");
			}


		}

	}



	
  //getting old data
  if(isset($_GET["id"])){
	$aId=$_GET["id"];
	global $ConnectingDB;
	$sql="SELECT * FROM class WHERE id='$aId'";
	$Execute=$ConnectingDB->query($sql);
	$DataRows=$Execute->fetch();

	if($Execute){
		$ClassName = $DataRows['cname'];
		$tid = $DataRows['tid'];
		$Datetime = $DataRows['datetime'];
		$Cid = $DataRows['id'];
	}else{
		$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
		Redirect_to("AddNewClass.php");
	}
}else{
	Redirect_to("AddNewClass.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Edit Class</title>
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
				<form class="" action="EditClass.php" method="post" id="">
					<div class="card mb-3">
						<div class="card-header">
							<h1>Edit Class</h1>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="title"><span class="FieldInfo">Class Title:</span></label>
								<input class="form-control" type="text" name="classname" id="title" placeholder="Type title here" value="<?php echo $ClassName;?>">
							</div>
							<input class="form-control" type="text" name="cid" value="<?php echo $Cid;?>" hidden>

							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Update Class
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				
			</div>
		</div>
	</section>



	<script>
		$('#year').text(new Date().getFullYear());
	</script>
</body>
</html>
