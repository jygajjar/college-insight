<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["TrackingURL"];
  Confirm_Teacher_Login();

  if(isset($_GET["id"])&&isset($_GET["cid"])){
		$ParameterOne=$_GET["id"];
  	$ParameterTwo=$_GET["cid"];
		global $ConnectingDB;
		$sql="UPDATE classroom SET status='unapproved' WHERE sid='$ParameterOne' AND cid='$ParameterTwo'";
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Student un-Approved SuccessFully ! ";
			Redirect_to("ManageStudent.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("ManageStudent.php");
		}
	}

?>
