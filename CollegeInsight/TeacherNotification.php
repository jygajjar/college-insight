<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Teacher_Login();

	if(isset($_POST["Submit"])){
		$ClassName=$_POST["classname"];

		global $ConnectingDB;
		$sql="SELECT id FROM class Where tid='$_SESSION[Teacher_Id]' and cname='$ClassName'";
		$stmt=$ConnectingDB->query($sql);
		if($DataRows=$stmt->fetch()){
			$CId=$DataRows["id"];
		}
		/*
		$Image=$_FILES["Image"]["name"];
		$Target="Images/".basename($Image);*/
		$Notification=$_POST["notification"];
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

		if(empty($ClassName)){
			$_SESSION["ErrorMessage"]="Classname can not be Empty";
			Redirect_to("TeacherNotification.php");
		}elseif(strlen($Notification)>9999){
			$_SESSION["ErrorMessage"]="Notification should be less than 10000 characters";
			Redirect_to("TeacherNotification.php");
		}else{
		//	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target)
			$sql="INSERT INTO notification(cid,textcontent,datetime) VALUES(:ciD,:textcoNtent,:datetIme)";
			$stmt=$ConnectingDB->prepare($sql);
			$stmt->bindValue(':ciD',$CId);
			$stmt->bindValue(':textcoNtent',$Notification);
			$stmt->bindValue(':datetIme',$DateTime);
			$Execute=$stmt->execute();

			if($Execute){
				$_SESSION["SuccessMessage"]="Notification Added Successfully";
				Redirect_to("TeacherNotification.php");
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
				Redirect_to("TeacherNotification.php");
			}


		}

	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Notification</title>
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
				<form class="" action="TeacherNotification.php" method="post" id="" enctype="multipart/form-data">
					<div class="card mb-3">
						<div class="card-header">
							<h1>Add Notification</h1>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="ClassTitle"><span class="FieldInfo">Choose Class:</span></label>
								<select class="form-control" id="ClassTitle" name="classname">
									<?php
										global $ConnectingDB;
										$sql="SELECT id,cname FROM class Where tid='$_SESSION[Teacher_Id]'";
										$stmt=$ConnectingDB->query($sql);
										$dataFound = false;
										while($DataRows=$stmt->fetch()){
											$dataFound = true;
											$Id=$DataRows["id"];
											$ClassName=$DataRows["cname"];
											echo "<option>".$ClassName."</option>";
										}

										if(!$dataFound){
											?>
											<option disabled>Empty Class</option>
									<?php
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="Post"><span class="FieldInfo">Notification:</span></label>
								<textarea class="form-control" id="Post" name="notification" rows="8" cols="80"></textarea>
							</div>
							<!--<div class="form-group">
								<div class="custom-file">
									<input class="custom-file-input" type="file" name="Image" id="imageSelect"  value="">
									<label for="imageSelect" class="custom-file-label">Select Attachment</label>
								</div>
							</div>-->
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Add Notification
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<h2>Notification</h2>
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Class Name</th>
							<th>Notification</th>
							<th>Date&Time</th>
							<th>Action</th>
						</tr>
					</thead>
				<tbody>

				<?php
				global $ConnectingDB;
				$sql="SELECT n.id as id,c.cname as cname,n.textcontent as textcontent,n.datetime as datetime FROM notification as n,class as c where c.id=n.cid and c.tid=$_SESSION[Teacher_Id]";
				$Execute=$ConnectingDB->query($sql);
				$SrNo=0;
				$dataFound = false;
				while($DataRows=$Execute->fetch()){
					$dataFound = true;
					$NotificationId=$DataRows["id"];
					$ClassName=$DataRows["cname"];
					$Notification=$DataRows["textcontent"];
					$uploaddate=$DataRows["datetime"];
					$SrNo++;
					
				?>
					<tr>
						<td><?php echo htmlentities($SrNo);?></td>
						<td><?php echo htmlentities($ClassName);?></td>
						<td><?php echo htmlentities($Notification);?></td>
						<td><?php echo htmlentities($uploaddate);?></td>
						<td><a href="editNotification.php?id=<?php echo $NotificationId;?>" class="btn btn-primary">Edit</a>
						<a href="deleteNotification.php?id=<?php echo $NotificationId;?>" class="btn btn-danger">Delete</a></td>
					</tr>
				<?php } 
					if(!$dataFound){
						?>
							<tr ><td colspan=4 class="h3">No Notification Found</td></tr>
							
				<?php
					}
				?>
				</tbody>
				</table>
				
				
				
				
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
