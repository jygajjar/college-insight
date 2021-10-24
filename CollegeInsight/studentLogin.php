<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");

	if(isset($_SESSION["UserEmail"])){
		Redirect_to("StudentDashboard.php");
	}

	if(isset($_POST["Submit"])){
		$UserName=$_POST["Username"];
		$Password=$_POST["Password"];

		if(empty($UserName)&&empty($Password)){
			$_SESSION["ErrorMessage"]="All Field must be Filled Out";
			Redirect_to("login.php");
		}else{

			$Found_Account=Login_Attempt($UserName,$Password);
			if($Found_Account){

				$Verified=$Found_Account["verified"];
			  		if($Verified==1){

								$_SESSION["User_Id"]=$Found_Account["id"];
								$_SESSION["UserFirstName"]=$Found_Account["firstname"];
								$_SESSION["UserLastName"]=$Found_Account["lastname"];
								$_SESSION["UserEmail"]=$Found_Account["email"];
								$_SESSION["UserProfilePhoto"]=$Found_Account["profilephoto"];
								$_SESSION["UserBio"]=$Found_Account["bio"];
								$_SESSION["Verified"]=$Found_Account["verified"];
								$_SESSION["SuccessMessage"]="Welcome ".$_SESSION["UserFirstName"]." ".$_SESSION["UserLastName"];

								global $ConnectingDB;
								$ip=$_SERVER["REMOTE_ADDR"];
								date_default_timezone_set("Asia/Kolkata");
								$CurrentTime=time();
								$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
								$Password = md5($Password);
								$sql="INSERT INTO loginlog(email,password,ip,role,status,datetime) VALUES('$_SESSION[UserEmail]','$Password','$ip','Student','Success','$DateTime')";
								$Execute=$ConnectingDB->query($sql);

							if(isset($_SESSION["TrackingURL"])&&$_SESSION["TrackingURL"]!=index.php){
								Redirect_to($_SESSION["TrackingURL"]);
							}else{
								Redirect_to("StudentDashboard.php");
							}
						}
						else {
							global $ConnectingDB;
							$ip=$_SERVER["REMOTE_ADDR"];
							date_default_timezone_set("Asia/Kolkata");
							$CurrentTime=time();
							$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
							$sql="INSERT INTO loginlog(email,password,ip,role,status,datetime) VALUES('$UserName','$Password','$ip','Student','Failed','$DateTime')";
							$Execute=$ConnectingDB->query($sql);

								$_SESSION["ErrorMessage"]="Email not verified !";
								Redirect_to("login.php");
						}
			}else{

					global $ConnectingDB;
					$ip=$_SERVER["REMOTE_ADDR"];
					date_default_timezone_set("Asia/Kolkata");
					$CurrentTime=time();
					$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
					$sql="INSERT INTO loginlog(email,password,ip,role,status,datetime) VALUES('$UserName','$Password','$ip','Student','Failed','$DateTime')";
					$Execute=$ConnectingDB->query($sql);

				$_SESSION["ErrorMessage"]="Incurrect Username/Password";
				Redirect_to("login.php");
			}
		}
	}
?>