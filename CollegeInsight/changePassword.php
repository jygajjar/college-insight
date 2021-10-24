<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
    $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
    //echo $_SESSION["TrackingURL"];
    Confirm_Teacher_Login();


  //updating new data
  if(isset($_POST["Submit"])){
	$uid=$_POST["userid"];
	$oldpassword=md5($_POST["oldpassword"]);
	$newpassword=md5($_POST["newpassword"]);
	$confirmnewpassword=md5($_POST["confirmnewpassword"]);
	
	if( !empty($_POST["oldpassword"]) && !empty($_POST["newpassword"]) && !empty($_POST["confirmnewpassword"])){
		if($newpassword===$confirmnewpassword){
            $sql="SELECT * FROM teacher WHERE id=:uiD AND password=:oldpaSsword ";
            $stmt=$ConnectingDB->prepare($sql);
            $stmt->bindValue(':uiD',$uid);
            $stmt->bindValue(':oldpaSsword',$oldpassword);
            $stmt->execute();
            $Result=$stmt->rowcount();
            if($Result==1){
                $isOldPasswordRight = true;
            }else{
                $isOldPasswordRight = false;
            }

            if($isOldPasswordRight){
                $sql="UPDATE teacher SET password='$newpassword' WHERE id='$uid'";
                $stmt=$ConnectingDB->query($sql);
                $Execute=$stmt->execute();

                if($Execute){
                    $_SESSION["SuccessMessage"]="Password changed Successfully";
                    Redirect_to("TeacherProfile.php");
                }else{
                    $_SESSION["ErrorMessage"]="Something went wrong.Try Again !";
                    Redirect_to("TeacherProfile.php");
                }
            }else{
                $_SESSION["ErrorMessage"]="You entered wrong old password !";
                Redirect_to("TeacherProfile.php");
            }
            
        }else{
            $_SESSION["ErrorMessage"]="New Password and Confirm Password Should match";
            Redirect_to("TeacherProfile.php");
        }
	}else{
        $_SESSION["ErrorMessage"]="All field must not be empty";
		Redirect_to("TeacherProfile.php");
    }
    
 
}

?>
