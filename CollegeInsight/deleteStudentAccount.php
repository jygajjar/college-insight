<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
  $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["TrackingURL"];
	Confirm_Login();

  if(isset($_POST["Submit"])){
	$uid=$_POST["userid"];
	$password=md5($_POST["password"]);

	if( !empty($_POST["password"])){
		$sql="SELECT * FROM student WHERE id=:uiD AND password=:paSsword ";
            $stmt=$ConnectingDB->prepare($sql);
            $stmt->bindValue(':uiD',$uid);
            $stmt->bindValue(':paSsword',$password);
            $stmt->execute();
            $Result=$stmt->rowcount();
            if($Result==1){
                $isPasswordRight = true;
            }else{
                $isPasswordRight = false;
            }

            if($isPasswordRight){
                global $ConnectingDB;
				$sql="DELETE FROM student WHERE id='$uid' ";
				$Execute=$ConnectingDB->query($sql);

				if($Execute){
					
                    $_SESSION["User_Id"]=null;
                    $_SESSION["UserEmail"]=null;
                    $_SESSION["UserFirstName"]=null;

					session_destroy();
					
					Redirect_To("index.php");
				}else{
					$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
					Redirect_to("MyProfile.php");
				}
            }else{
                $_SESSION["ErrorMessage"]="You entered wrong password !";
                Redirect_to("MyProfile.php");
            }
	}else{
        $_SESSION["ErrorMessage"]="Password Required";
		Redirect_to("MyProfile.php");
    }	
}


?>
