<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Teacher_Login();

	$TeacherId=$_SESSION["Teacher_Id"];
	global $ConnectingDB;
	$sql="SELECT * FROM teacher WHERE id='$TeacherId'";
	$stmt=$ConnectingDB->query($sql);
	while($DataRows=$stmt->fetch()){
		$ExistingEmail=$DataRows['email'];
		$ExistingFirstName=$DataRows['firstname'];
		$ExistingLastName=$DataRows["lastname"];
		$ExistingBio=$DataRows['bio'];
		$ExistingImage=$DataRows["profilephoto"];
	}
	if(isset($_POST["Submit"])){
		$FirstName=$_POST["firstname"];
		$LastName=$_POST["lastname"];
		$Email=$_POST["email"];
		$ABio=$_POST["Bio"];
		$Image=$_FILES["Image"]["name"];
		$Target="Images/".basename($Image);

		if(strlen($FirstName)>15){
			$_SESSION["ErrorMessage"]="Firstname should be less than 15 characters";
			Redirect_to("TeacherProfile.php");
		}elseif(strlen($LastName)>15){
			$_SESSION["ErrorMessage"]="Lastname should be less than 15 characters";
			Redirect_to("TeacherProfile.php");
		}elseif(strlen($ABio)>500){
			$_SESSION["ErrorMessage"]="Bio should be less than 500 characters";
			Redirect_to("TeacherProfile.php");
		}else{
			global $ConnectingDB;
			if(!empty($_FILES["Image"]["name"])){
				$sql="UPDATE teacher
					SET firstname='$FirstName',lastname='$LastName',email='$Email',bio='$ABio',profilephoto='$Image'
					WHERE id='$TeacherId'";
			}else{
				$sql="UPDATE teacher
					SET firstname='$FirstName',lastname='$LastName',email='$Email',bio='$ABio'
					WHERE id='$TeacherId'";
			}

			$Execute=$ConnectingDB->query($sql);
			move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);


			if($Execute){
				$_SESSION["SuccessMessage"]="Details Updated Successfully";
				Redirect_to("TeacherProfile.php");
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
				Redirect_to("TeacherProfile.php");
			}


		}

	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>My Profile</title>
</head>
<body>
<?php require_once("Includes/header.php");?>



<section class="container py-2 mt-4">
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<div class="card-header">
						<h3><?php echo $ExistingFirstName." ".$ExistingLastName;?></h3>
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
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
				<div class="card">
					<div class="card-header ">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active" href="#editProfile" data-toggle="tab">Edit Profile</a></li>
							<li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a></li>
							<li class="nav-item"><a class="nav-link" href="#deleteAccount" data-toggle="tab">Delete Account</a></li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<div class="active tab-pane" id="editProfile">
								<form class="" action="TeacherProfile.php" method="post" id="" enctype="multipart/form-data">
									<div class="row">
										<div class="form-group col-md-6">
											<input class="form-control" type="text" name="firstname" id="title" placeholder="Firstname" value="<?php echo $ExistingFirstName;?>">
										</div>
										<div class="form-group col-md-6">
											<input class="form-control" type="text" name="lastname" id="title" placeholder="Lastname" value="<?php echo $ExistingLastName;?>">
										</div>
									</div>
									<div class="form-group">
										<input class="form-control" type="email" placeholder="Email" name="email" value="<?php echo $ExistingEmail;?>" readonly>
									</div>
									<div class="form-group">
										<textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"><?php echo $ExistingBio;?></textarea>
									</div>
									<div class="form-group">
										<div class="custom-file">
											<input class="custom-file-input" type="file" name="Image" id="imageSelect"  value="">
											<label for="imageSelect" class="custom-file-label">Select Image</label>
										</div>
									</div>
									<div class="row" >
										<div class="col-lg-6 mb-2">
											<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
										</div>
										<div class="col-lg-6 mb-2">
											<button type="submit" name="Submit" class="btn btn-success btn-block">
												<i class="fas fa-check"></i>Update Profile
											</button>
										</div>
									</div>
								</form>
							</div>
							<div class=" tab-pane" id="changePassword">
								<form class="" action="changePassword.php" method="post" id="" enctype="multipart/form-data">
									<input type="text" name="userid"  value="<?php echo $_SESSION['Teacher_Id'];?>" hidden>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Old Password" name="oldpassword" >
									</div>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="New Password" name="newpassword" >
									</div>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Confirm New Password" name="confirmnewpassword" >
									</div>
									<input type="text" name="userid"  value="<?php echo $_SESSION['Teacher_Id'];?>" hidden>

									<div class="row" >
										<div class="col-lg-6 mb-2">
											<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
										</div>
										<div class="col-lg-6 mb-2">
											<button type="submit" name="Submit" class="btn btn-primary btn-block">
												<i class="fas fa-"></i>Change Password
											</button>
										</div>
									</div>
								</form>
							</div>
							<div class=" tab-pane" id="deleteAccount">
								<form class="" action="DeleteAccount.php" method="post" id="" enctype="multipart/form-data">
									<input type="text" name="userid"  value="<?php echo $_SESSION['Teacher_Id'];?>" hidden>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Password" name="password" >
									</div>
									<div class="row" >
										<div class="col-lg-6 mb-2">
											<a href="TeacherDashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
										</div>
										<div class="col-lg-6 mb-2">
											<button type="submit" name="Submit" class="btn btn-danger btn-block">
												<i class="fas fa-trash"></i>Delete Account
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
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
