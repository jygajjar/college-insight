<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");


	if(isset($_GET["wid"])){
		$wid=$_GET["wid"];
		$cid=$_GET["c"];
		global $ConnectingDB;

        $sql="UPDATE std_work SET status='approved' WHERE id='$wid'";
		$stmt=$ConnectingDB->query($sql);
		$Execute=$stmt->execute();

			

		if($Execute){
			$_SESSION["SuccessMessage"]="Class updated Successfully";
			Redirect_to("TeacherClass.php?cid=$cid&&action=submittedassignment");
		}else{
			$_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
			Redirect_to("TeacherClass.php?cid=$cid&&action=submittedassignment");
		}
	}

?>
