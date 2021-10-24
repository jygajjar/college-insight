<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Teacher_Login();

	if(isset($_POST["Submit"])){
		$ClassName=$_POST["ClassTitle"];
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

			$sql="INSERT INTO class(cname,tid,datetime)";
			$sql.="VALUES(:clasSname,:tId,:dateTime)";
			$stmt=$ConnectingDB->prepare($sql);
			$stmt->bindValue(':clasSname',$ClassName);
			$stmt->bindValue(':tId',$TeacherId);
			$stmt->bindValue(':dateTime',$DateTime);
			$Execute=$stmt->execute();

			if($Execute){
				$_SESSION["SuccessMessage"]="Class Added Successfully";
				Redirect_to("AddNewClass.php");
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
				Redirect_to("AddNewClass.php");
			}


		}

	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Class</title>
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
				<form class="" action="AddNewClass.php" method="post" id="">
					<div class="card  mb-3">
						<div class="card-header">
							<h1>Add New Class</h1>
						</div>
						<div class="card-body ">
							<div class="form-group">
								<label for="title"><span class="FieldInfo">Class Title:</span></label>
								<input class="form-control" type="text" name="ClassTitle" id="title" placeholder="Type title here" value="">
							</div>
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Add Class
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<h2>Existing Class</h2>
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Class Name</th>
							<th>Date&Time</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
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
					<tr>
						<td><?php echo htmlentities($SrNo);?></td>
						<td><?php echo htmlentities($ClassName);?></td>
						<td><?php echo htmlentities($ClassDate);?></td>
						<td><a href="EditClass.php?id=<?php echo $ClassId;?>" class="btn btn-primary">Edit</a>
						<a href="DeleteClass.php?id=<?php echo $ClassId;?>" class="btn btn-danger">Delete</a></td>
					</tr>
				<?php } 
				if(!$dataFound){
					?>
						<tr ><td colspan=4 class="h3">No Existing Class Found</td></tr>
						
			<?php
				}
				?>
					</tbody>
				</table>
			</div>
		</div>
	</section>



	<script>
		$('#year').text(new Date().getFullYear());
	</script>
</body>
</html>
