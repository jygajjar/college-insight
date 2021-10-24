<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");


	if(isset($_GET["id"])){
		$SearchQueryParameter=$_GET["id"];
		global $ConnectingDB;
		$sql="DELETE FROM class WHERE id='$SearchQueryParameter'";
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Class Deleted SuccessFully ! ";
			Redirect_to("AddNewClass.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("AddNewClass.php");
		}
	}

?>
