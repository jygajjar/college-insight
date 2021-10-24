<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["TrackingURL"];
  Confirm_Teacher_Login();

  	global $ConnectingDB;
		$sql="UPDATE classroom SET status='approved' WHERE tid='$_SESSION[Teacher_Id]'";
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="All Student Approved SuccessFully ! ";
			Redirect_to("ManageStudent.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("ManageStudent.php");
		}

?>
