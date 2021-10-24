<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
  Confirm_Teacher_Login();

  if(isset($_GET["c"])){
	if(isset($_GET["id"])){
		$aId=$_GET["id"];
		$cid=$_GET["c"];
		global $ConnectingDB;
		$sql="DELETE FROM notification WHERE id='$aId'";
		
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Notification Deleted SuccessFully ! ";
			Redirect_to("TeacherClass.php?cid=$cid&&action=notificationlist");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("TeacherClass.php?cid=$cid&&action=notificationlist");
		}
	}
  }
  else{
	if(isset($_GET["id"])){
		$aId=$_GET["id"];
		global $ConnectingDB;
		$sql="DELETE FROM notification WHERE id='$aId'";
		
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Notification Deleted SuccessFully ! ";
			Redirect_to("TeacherNotification.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("TeacherNotification.php");
		}
	}
  }
  

?>
