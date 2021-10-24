<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");

  if(isset($_SESSION["TeacherEmail"])){
		Redirect_to("TeacherDashboard.php");
	}

	if(isset($_POST["Submit"])){
		$TeacherFirstName=$_POST["firstname"];
		$TeacherLastName=$_POST["lastname"];
		$UserName=$_POST["email"];
		$Password=$_POST["tpass"];
		$Vkey=md5(date('m/d/Y h:i:s', time()));
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);



		if(empty($TeacherFirstName)&&empty($TeacherLastName)&&empty($UserName)&&empty($Password)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("Registration.php");
		}else{
			$Found_Account=Login_Attempt_By_Teacher($UserName,$Password);
			if($Found_Account){
        $_SESSION["ErrorMessage"]="Email Already Exist!";
        Redirect_to("Registration.php");
			}else{
				$_SESSION["SuccessMessage"]="Teacher Registered Successfully!";
        AddTeacher($TeacherFirstName,$TeacherLastName,$UserName,$Password,$Vkey,$DateTime);
		Redirect_to("login.php");
			}
		}
	}
?>