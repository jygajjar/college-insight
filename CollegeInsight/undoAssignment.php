<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");

	Confirm_Login();

	if(isset($_GET["id"])){
		$SearchQueryParameter=$_GET["id"];
		$Cid=$_GET["cid"];
		global $ConnectingDB;
		$sql="DELETE FROM std_work WHERE id='$SearchQueryParameter'";
		$Execute=$ConnectingDB->query($sql);
		$link = "ClassRoom.php?id=".$Cid."&&action=subassignment";
		if($Execute){
			$_SESSION["SuccessMessage"]="Assignment Deleted SuccessFully ! Now resubmit it ";
			Redirect_to($link);
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to($link);
		}
	}

?>
