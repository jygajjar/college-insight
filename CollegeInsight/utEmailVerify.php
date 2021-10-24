<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  if(isset($_GET["vkey"])){
		$ParameterOne=$_GET["vkey"];
		global $ConnectingDB;
		$sql="UPDATE teacher SET verified='1' WHERE vkey='$ParameterOne'";
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Email Verified SuccessFully ! ";
			Redirect_to("TeacherLogin.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("TeacherRegistration.php");
		}
	}

?>
