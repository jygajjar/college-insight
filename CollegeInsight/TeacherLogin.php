<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");

  if(isset($_SESSION["TeacherEmail"])){
		Redirect_to("TeacherDashboard.php");
	}

	if(isset($_POST["Submit"])){
		$UserName=$_POST["Username"];
		$Password=$_POST["Password"];
		if(empty($UserName)&&empty($Password)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("login.php");
		}else{
			$Found_Account=Login_Attempt_By_Teacher($UserName,$Password);
			if($Found_Account){
				$Verified=$Found_Account["verified"];
				if($Verified==1){

				$_SESSION["Teacher_Id"]=$Found_Account["id"];
				$_SESSION["TeacherFirstName"]=$Found_Account["firstname"];
				$_SESSION["TeacherLastName"]=$Found_Account["lastname"];
				$_SESSION["TeacherEmail"]=$Found_Account["email"];
				$_SESSION["TeacherBio"]=$Found_Account["bio"];
				$_SESSION["TeacherStatus"]=$Found_Account["status"];
				$_SESSION["Verified"]=$Found_Account["verified"];
				$_SESSION["TeacherProfilePhoto"]=$Found_Account["profilephoto"];
				$_SESSION["SuccessMessage"]="Welcome ".$_SESSION["TeacherFirstName"]." ".$_SESSION["TeacherLastName"];



					global $ConnectingDB;
					$ip=$_SERVER["REMOTE_ADDR"];
					date_default_timezone_set("Asia/Kolkata");
					$CurrentTime=time();
					$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
					$sql="INSERT INTO loginlog(email,password,ip,role,status,datetime) VALUES('$_SESSION[TeacherEmail]','$Password','$ip','Teacher','Success','$DateTime')";
					$Execute=$ConnectingDB->query($sql);

				if(isset($_SESSION["TrackingURL"])){
					Redirect_to($_SESSION["TrackingURL"]);
				}else{
					Redirect_to("TeacherDashboard.php");
				}
			}
			else {

					global $ConnectingDB;
					$ip=$_SERVER["REMOTE_ADDR"];
					date_default_timezone_set("Asia/Kolkata");
					$CurrentTime=time();
					$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
					$sql="INSERT INTO loginlog(email,password,ip,role,status,datetime) VALUES('$UserName','$Password','$ip','Teacher','Failed','$DateTime')";
					$Execute=$ConnectingDB->query($sql);

					$_SESSION["ErrorMessage"]="Email not verified !";
					Redirect_to("login.php");
			}
			}
			else
			{

					global $ConnectingDB;
					$ip=$_SERVER["REMOTE_ADDR"];
					date_default_timezone_set("Asia/Kolkata");
					$CurrentTime=time();
					$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
					$sql="INSERT INTO loginlog(email,password,ip,role,status,datetime) VALUES('$UserName','$Password','$ip','Teacher','Failed','$DateTime')";
					$Execute=$ConnectingDB->query($sql);

				$_SESSION["ErrorMessage"]="Incurrect Username/Password";
				Redirect_to("login.php");
			}
		}
	}else{
		Redirect_to("login.php");
	}
?>