<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["TrackingURL"];
  Confirm_Teacher_Login();

  if(isset($_GET["c"])){
	if(isset($_GET["id"])){
		$aId=$_GET["id"];
		$cId=$_GET["c"];
		global $ConnectingDB;
		$sql="DELETE FROM assignment WHERE id='$aId'";
		
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Student Deleted SuccessFully ! ";
			Redirect_to("TeacherClass.php?cid=$cId&&action=assignment");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("TeacherClass.php?cid=$cId&&action=assignment");
		}
	}
  }else{
	if(isset($_GET["id"])){
		$aId=$_GET["id"];
		global $ConnectingDB;
		$sql="DELETE FROM assignment WHERE id='$aId'";
		
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Student Deleted SuccessFully ! ";
			Redirect_to("TeacherAssignment.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("TeacherAssignment.php");
		}
	}
  }
  

?>
