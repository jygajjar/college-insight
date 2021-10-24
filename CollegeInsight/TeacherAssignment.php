<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Teacher_Login();

	if(isset($_POST["Submit"])){
		$AssignDescription=$_POST["AssignDescription"];
		$AssignName=$_POST["assignmentTitle"];
		$ClassId=$_POST["classid"];
		$LastDate=$_POST["deadline"];
		$Image=$_FILES["Image"]["name"];
		$Target="Images/".basename($Image);
		$T_Id=$_SESSION["Teacher_Id"];
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

		if(empty($AssignDescription)){
			$_SESSION["ErrorMessage"]="Assignment Description can not be Empty";
			Redirect_to("TeacherAssignment.php");
		}elseif(strlen($AssignDescription)<5){
			$_SESSION["ErrorMessage"]="Assignment Description should be greater than 5 characters";
			Redirect_to("TeacherAssignment.php");
		}elseif(strlen($AssignDescription)>9999){
			$_SESSION["ErrorMessage"]="Assignment Description should be less than 10000 characters";
			Redirect_to("TeacherAssignment.php");
		}else{

			if(move_uploaded_file($_FILES["Image"]["tmp_name"],$Target)){
				$sql="INSERT INTO assignment(aname,tid,title,cid,uploaddate,lastdate,amedia)";
				$sql.="VALUES(:anaMe,:Tid,:tiTle,:cId,:uploAddate,:laStdate,:amEdia)";
				$stmt=$ConnectingDB->prepare($sql);
				$stmt->bindValue(':anaMe',$AssignDescription);
				$stmt->bindValue(':Tid',$T_Id);
				$stmt->bindValue(':tiTle',$AssignName);
				$stmt->bindValue(':cId',$ClassId);
				$stmt->bindValue(':uploAddate',$DateTime);
				$stmt->bindValue(':laStdate',$LastDate);
				$stmt->bindValue(':amEdia',$Image);
				$Execute=$stmt->execute();
				

				if($Execute){
					$_SESSION["SuccessMessage"]="Assignment Added Successfully";
					Redirect_to("TeacherAssignment.php");
				}else{
					$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
					Redirect_to("TeacherAssignment.php");
				}
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong with attachment";
				Redirect_to("TeacherAssignment.php");
			}

		}

	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Assignment</title>
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
				<form class="" action="TeacherAssignment.php" method="post" id="" enctype="multipart/form-data">
					<div class="card mb-3">
						<div class="card-header">
							<h1>Add Assignment</h1>
						</div>
						<div class="card-body ">
							<div class="form-group">
								<label for="ClassName"><span class="FieldInfo">Choose Class:</span></label>
								<select class="form-control" id="ClassName" name="classid">
									<?php
										$dataFound = false;
										global $ConnectingDB;
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
              				
							<div class="form-group">
								<label for="assignmentTitle"><span class="FieldInfo">Assignment Title:</span></label>
								<input class="form-control" id="assignmentTitle" type="text" name="assignmentTitle" placeholder="Enter Assignment Title">
							</div>
							
              				<div class="form-group">
								<label for="Post"><span class="FieldInfo">Assignment Description:</span></label>
								<textarea class="form-control" id="Post" name="AssignDescription" rows="8" cols="80"></textarea>
							</div>
							<div class="form-group">
								<label for="Deadline"><span class="FieldInfo">Deadline:</span></label>
								<input class="form-control" id="Deadline" type="date" name="deadline" placeholder="Enter Deadline">
							</div>
							<div class="form-group">
								<div class="custom-file">
									<input class="custom-file-input" type="file" name="Image" id="imageSelect"  value="">
									<label for="imageSelect" class="custom-file-label">Select Attachment</label>
								</div>
							</div>
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Add Assignment
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				
				<h2>Assignment</h2>
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Assignment Name</th>
							<th>Uploaded at</th>
							<th>Due date</th>
							<th>Action</th>
						</tr>
					</thead>
				<tbody>

				<?php
				global $ConnectingDB;
				$sql="SELECT * FROM assignment where tid=$_SESSION[Teacher_Id] ORDER BY id desc";
				$Execute=$ConnectingDB->query($sql);
				$SrNo=0;
				$dataFound = false;
				while($DataRows=$Execute->fetch()){
					$dataFound = true;
					$AssignmentId=$DataRows["id"];
					$ClassId=$DataRows["cid"];
					$AssignmentName=$DataRows["aname"];
					$uploaddate=$DataRows["uploaddate"];
					$lastdate=$DataRows["lastdate"];
					$amedia=$DataRows["amedia"];
					$SrNo++;


				?>
					<tr>
						<td><?php echo htmlentities($SrNo);?></td>
						<td><?php echo htmlentities($AssignmentName);?></td>
						<td><?php echo htmlentities($uploaddate);?></td>
						<td><?php echo htmlentities($lastdate);?></td>
						<td><a href="EditAssignment.php?id=<?php echo $AssignmentId;?>" class="btn btn-primary">Edit</a>
						<a href="DeleteAssignment.php?id=<?php echo $AssignmentId;?>" class="btn btn-danger">Delete</a></td>
					</tr>
				<?php } 
					if(!$dataFound){
						?>
							<tr ><td colspan=4 class="h3">No Assignment Found</td></tr>
							
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

		$('.custom-file-input').on('change',function(){
			var x = this.value.replace(/.*(\/|\\)/,'');
			$('.custom-file-label').html(x);
		});


		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){
				dd='0'+dd
			} 
			if(mm<10){
				mm='0'+mm
			} 

		today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("Deadline").setAttribute("min", today);
	</script>
</body>
</html>
