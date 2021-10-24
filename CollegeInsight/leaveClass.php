<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
    $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
    //echo $_SESSION["TrackingURL"];
	Confirm_Login();

    if(isset($_GET['id'])){
        $ClassId = $_GET["id"];
        $Sid = $_SESSION["User_Id"];
		global $ConnectingDB;
		$sql="DELETE FROM classroom WHERE cid=$ClassId and sid=$Sid";
		$Execute=$ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="You Left Class successfully ! ";
			Redirect_to("ClassRoom.php");
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("ClassRoom.php");
		}
    }else{
        echo '<p style="color:red;margin:200px;margin-left:300px;font-size:100px;">Access Denied</p>';
    }

?>
