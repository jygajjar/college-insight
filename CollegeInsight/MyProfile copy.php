<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Login();

	$StudentId=$_SESSION["User_Id"];
	global $ConnectingDB;
	$sql="SELECT * FROM student WHERE id='$StudentId'";
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
			$_SESSION["ErrorMessage"]="FirstName should be less than 15 characters";
			Redirect_to("MyProfile.php");
		}elseif(strlen($LastName)>15){
			$_SESSION["ErrorMessage"]="LastName should be less than 15 characters";
			Redirect_to("MyProfile.php");
		}elseif(strlen($ABio)>500){
			$_SESSION["ErrorMessage"]="Bio should be less than 500 characters";
			Redirect_to("MyProfile.php");
		}else{
			global $ConnectingDB;
			if(!empty($_FILES["Image"]["name"])){
				$sql="UPDATE student
					SET firstname='$FirstName',lastname='$LastName',bio='$ABio',profilephoto='$Image'
					WHERE id='$StudentId'";
			}else{
				$sql="UPDATE student
					SET firstname='$FirstName',lastname='$LastName',bio='$ABio'
					WHERE id='$StudentId'";
			}

			$Execute=$ConnectingDB->query($sql);
			move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);


			if($Execute){
				$_SESSION["SuccessMessage"]="Details Updated Successfully";
				Redirect_to("MyProfile.php");
			}else{
				$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
				Redirect_to("MyProfile.php");
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
	
<?php require_once("Includes/studentHeader.php");?>

	<header class="bg-dark text-white py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1><i class="fas fa-user text-success mr-2"></i><?php echo $ExistingFirstName." ".$ExistingLastName;?></h1>
					<small>Student<?php// echo $ExistingStatus;?></small>
				</div>
			</div>
		</div>
	</header>


	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<div class="card-header bg-dark text-light">
						<h3><?php echo $ExistingFirstName;?></h3>
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
				<form class="" action="MyProfile.php" method="post" id="" enctype="multipart/form-data">
					<div class="card bg-dark text-light">
						<div class="card-header bg-secondary text-light">
							<h4>Edit Profile</h4>
						</div>
						<div class="card-body">
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
									<a href="index.html" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Update
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>


		<div class="row">
			
			<div class="col-md-9 offset-3 mt-3" style="min-height:4px;">
			
				<form class="" action="changeStudentPassword.php" method="post" id="" enctype="multipart/form-data">
					<div class="card bg-dark text-light">
						<div class="card-header bg-secondary text-light">
							<h4 class="">Change Password</h4>
						</div>
						<div class="card-body">
							<input type="text" name="userid"  value="<?php echo $StudentId;?>" hidden>
							<div class="form-group">
								<input class="form-control" type="password" placeholder="Old Password" name="oldpassword" >
							</div>
							<div class="form-group">
								<input class="form-control" type="password" placeholder="New Password" name="newpassword" >
							</div>
							<div class="form-group">
								<input class="form-control" type="password" placeholder="Confirm New Password" name="confirmnewpassword" >
							</div>
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-primary btn-block">
										<i class="fas fa-"></i>Change Password
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>



		
		<div class="row">
			
			<div class="col-md-9 offset-3 mt-3" style="min-height:40px;">
			
				<form class="" action="DeleteStudentAccount.php" method="post" id="" enctype="multipart/form-data">
					<div class="card bg-dark text-light">
						<div class="card-header bg-secondary text-light">
							<h4 class="">Delete Account</h4>
						</div>
						<div class="card-body">
							<input type="text" name="userid"  value="<?php echo $StudentId;?>" hidden>
							<div class="form-group">
								<input class="form-control" type="password" placeholder="Password" name="password" >
							</div>
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-danger btn-block">
										<i class="fas fa-trash"></i>Delete Account
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
