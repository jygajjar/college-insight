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
								<div class="col-lg-3 mb-2">
									<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-9 mb-2">
									<a class="btn btn-success float-right" href="AddStudentToClass.php">Add New Student</a>
								</div>
			<div class="col-lg-12">
        <h1 class="h1">Un-Approved Student</h1>
				<a class="btn btn-dark float-right" href="approveallstudent.php">Approve All Student</a>
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
					<tr>
						<th>#</th>
            <th>Profile Photo</th>
						<th>Name</th>
						<th>Email</th>
						<th>Class Name</th>
						<th>Action</th>
						<th>Profile</th>
					</tr>
					</thead>
					<?php
					global $ConnectingDB;
					$sql="SELECT student.id as id,student.email as email,student.firstname as firstname,student.lastname as lastname,class.cname as cname,student.profilephoto as profilephoto,class.id as cid FROM classroom join class on (classroom.cid=class.id) join student on (classroom.sid=student.id) where class.tid='$_SESSION[Teacher_Id]' AND classroom.status='unapproved'";
					$stmt=$ConnectingDB->query($sql);
					$Sr=0;
					$dataFound = false;
					while($DataRows=$stmt->fetch()){
						$dataFound = true;
						$Id=$DataRows["id"];
						$StudentEmail=$DataRows["email"];
						$SFirstName=$DataRows["firstname"];
						$SLastName=$DataRows["lastname"];
						$ClassName=$DataRows["cname"];
						$ClassId=$DataRows["cid"];
						$Image=$DataRows["profilephoto"];
						$Sr++;
						if(strlen($StudentEmail)>15){
							$StudentEmail=substr($StudentEmail,0,14).'...';
						}
						echo "<tbody><tr>";
						echo "<td>".$Sr."</td>";
						echo '<td><img src="Images/'.$Image.'" width="70px" height="70px"></td>';
						echo "<td>".$SFirstName." ".$SLastName."</td>";
						echo "<td>".$StudentEmail."</td>";
						echo "<td>".$ClassName."</td>";
						echo '<td><a href="ApproveStudent.php?id='.$Id.'&cid='.$ClassId.'"><span class="btn btn-success">Approve</span></a>
								<a href="DeleteStudent.php?id='.$Id.'&cid='.$ClassId.'"><span class="btn btn-danger">Delete</span></a></td>';
						echo '<td><a href="Profile.php?sid='.$Id.'" target="_blank"><span class="btn btn-primary">Profile</span></a></td>';
						echo "</tr></tbody>";
					}


					if(!$dataFound){
						?>
						<tbody>
							<tr ><td colspan=4 class="h3">No Student Found</td></tr>
							</tbody>
				<?php
					}
					?>
				</table>
			</div>
		</div>




      <div class="row">
        <div class="col-lg-12">
          <h1 class="h1">Approved Student</h1>
					<a class="btn btn-dark float-right" href="disapproveallstudent.php">un-Approve All Student</a>
        <?php
          echo ErrorMessage();
          echo SuccessMessage();
        ?>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Profile Photo</th>
              <th>Name</th>
              <th>Email</th>
              <th>Class Name</th>
              <th>Action</th>
              <th>Profile</th>
            </tr>
            </thead>
            <?php
						global $ConnectingDB;
						$sql="SELECT student.id as id,student.email as email,student.firstname as firstname,student.lastname as lastname,class.cname as cname,student.profilephoto as profilephoto,class.id as cid FROM classroom join class on (classroom.cid=class.id) join student on (classroom.sid=student.id) where class.tid='$_SESSION[Teacher_Id]' AND classroom.status='approved'";
						$stmt=$ConnectingDB->query($sql);
						$Sr=0;
						$dataFound = false;
						while($DataRows=$stmt->fetch()){
							$dataFound = true;
							$Id=$DataRows["id"];
							$StudentEmail=$DataRows["email"];
							$SFirstName=$DataRows["firstname"];
							$SLastName=$DataRows["lastname"];
							$ClassName=$DataRows["cname"];
							$ClassId=$DataRows["cid"];
							$Image=$DataRows["profilephoto"];
							$Sr++;
							if(strlen($StudentEmail)>15){
								$StudentEmail=substr($StudentEmail,0,14).'...';
							}
							echo "<tbody><tr>";
							echo "<td>".$Sr."</td>";
							echo '<td><img src="Images/'.$Image.'" width="70px" height="70px"></td>';
							echo "<td>".$SFirstName." ".$SLastName."</td>";
							echo "<td>".$StudentEmail."</td>";
							echo "<td>".$ClassName."</td>";
							echo '<td><a href="DisApproveStudent.php?id='.$Id.'&cid='.$ClassId.'"><span class="btn btn-warning">DisApprove</span></a>
									<a href="DeleteStudent.php?id='.$Id.'&cid='.$ClassId.'"><span class="btn btn-danger">Delete</span></a></td>';
							echo '<td><a href="Profile.php?sid='.$Id.'" target="_blank"><span class="btn btn-primary">Profile</span></a></td>';
							echo "</tr></tbody>";
						}

						if(!$dataFound){
							?>
							<tbody>
								<tr ><td colspan=4 class="h3">No Student Found</td></tr>
								</tbody>
					<?php
						}
            ?>
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
