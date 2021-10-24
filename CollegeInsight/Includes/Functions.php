<?php
	require_once("Includes/DB.php");
	function Redirect_to($New_Location){
		header("Location:".$New_Location);
		exit();
	}

	function CheckUserNameExistsOrNot($UserName){
		global $ConnectingDB;
		$sql="SELECT email FROM student WHERE email=:userName";
		$stmt=$ConnectingDB->prepare($sql);
		$stmt->bindValue(':userName',$UserName);
		$stmt->execute();
		$Result=$stmt->rowcount();
		if($Result==1){
			return true;
		}else{
			return false;
		}
	}

	function CheckUserNameExistsOrNotInClass($SId,$CId){
		global $ConnectingDB;
		$sql="SELECT sid FROM classroom WHERE cid=:ciD AND sid=:siD ";
		$stmt=$ConnectingDB->prepare($sql);
		$stmt->bindValue(':ciD',$CId);
		$stmt->bindValue(':siD',$SId);
		$stmt->execute();
		$Result=$stmt->rowcount();
		if($Result>=1){
			return true;
		}else{
			return false;
		}
	}

	function CheckClassCodeValidOrNot($ClassCode){
		global $ConnectingDB;

		$sql = "SELECT * FROM class WHERE id = :clasScode";
		$stmt=$ConnectingDB->prepare($sql);
		$stmt->bindValue(':clasScode',$ClassCode);
		$stmt->execute();
		$Result=$stmt->rowcount();
		if($Result){
			return true;
		}else{
			return false;
		}
	}


	function CheckAssignmentExistOrNot($Aid,$u_id){
		global $ConnectingDB;
		$sql="SELECT sid FROM std_work WHERE aid=:aiD AND sid=:siD ";
		$stmt=$ConnectingDB->prepare($sql);
		$stmt->bindValue(':aiD',$Aid);
		$stmt->bindValue(':siD',$u_id);
		$stmt->execute();
		$Result=$stmt->rowcount();
		if($Result==1){
			return true;
		}else{
			return false;
		}
	}


	function Login_Attempt($UserName,$Password){
			global $ConnectingDB;
			$sql="SELECT * FROM student WHERE email=:userName AND password=:passWord LIMIT 1";
			$stmt=$ConnectingDB->prepare($sql);
			$stmt->bindValue(':userName',$UserName);
			$stmt->bindValue(':passWord',md5($Password));
			$stmt->execute();
			$Result=$stmt->rowcount();
			if($Result==1){
				return $Found_Account=$stmt->fetch();
			}
			else
			{
				return false;
			}
	}


		function Login_Attempt_By_Teacher($UserName,$Password){
				global $ConnectingDB;
				$sql="SELECT * FROM teacher WHERE email=:userName AND password=:passWord LIMIT 1";
				$stmt=$ConnectingDB->prepare($sql);
				$stmt->bindValue(':userName',$UserName);
				$stmt->bindValue(':passWord',md5($Password));
				$stmt->execute();
				$Result=$stmt->rowcount();
				if($Result==1){
					return $Found_Account=$stmt->fetch();
				}else{
					return false;
				}
		}

	function Confirm_Login(){
		if(isset($_SESSION["UserEmail"])){
			return true;
		}else{
			$_SESSION["ErrorMessage"]="Login Required !";
			Redirect_to("login.php");
		}
	}

		function Confirm_Teacher_Login(){
			if(isset($_SESSION["TeacherEmail"])){
				return true;
			}else{
				$_SESSION["ErrorMessage"]="Login Required !";
				Redirect_to("TeacherLogin.php");
			}
		}

			function AddTeacher($TeacherFirstName,$TeacherLastName,$UserName,$Password,$Vkey,$DateTime){
				global $ConnectingDB;
				$mailFunction=true;
				$sqladd="INSERT INTO teacher (firstname,lastname,email,password,profilephoto,vkey,verified,datetime) ";
				$sqladd.="VALUES (:firsTname,:laStname,:eMail,:paSsword,'avatar.png',:vKey,'0',:datetimE)";
				$stmtadd=$ConnectingDB->prepare($sqladd);
				$stmtadd->bindValue(':firsTname',$TeacherFirstName);
				$stmtadd->bindValue(':laStname',$TeacherLastName);
				$stmtadd->bindValue(':eMail',$UserName);
				$stmtadd->bindValue(':paSsword',md5($Password));
				$stmtadd->bindValue(':vKey',$Vkey);
				$stmtadd->bindValue(':datetimE',$DateTime);
				$Execute=$stmtadd->execute();
				if($Execute){
					$subject="Confirmation for CollegeInsight";
					$message="<!DOCTYPE html>
								<html>
								<head>
								<style>
								.button {
								display: inline-block;
								padding: 15px 25px;
								font-size: 30px;
								cursor: pointer;
								text-align: center;
								text-decoration: none;
								outline: none;
								color: white;
								background-color: #00b33c;
								border: none;
								border-radius: 15px;
								box-shadow: 0 9px #4dd2ff;
								}

								.button:hover {background-color: #008000}

								.button:active {
								background-color: #1a1aff;
								box-shadow: 0 5px #666;
								transform: translateY(4px);
								}
								</style>
								</head>
								<body>
								<h2>Hi ".$TeacherFirstName." ".$TeacherLastName.",</h2>
								<h3> Verify your email for CollegeInsight by click below link. it is only valid for 5 minutes. </h3>
								<a href='http://localhost/CollegeInsight/utEmailVerify.php?vkey=".$Vkey."'>
								<button class='button'>Verify Email</button></a>
								<br><br>
								</body>
								</html>
								Please do not share this link with anyone. if this was not you, contact our support team at http://localhost/collegeinsight/contactUs.php";
					$headers="from: CollegeInsight <collegeinsight.ketan@gmail.com>\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					if($mailFunction){
						if(mail($UserName,$subject,$message,$headers)){
							$_SESSION["SuccessMessage"]="Teacher Registration Success! Verification mail sent to ".$UserName."";
							Redirect_to("TeacherLogin.php");
						}
						else
						{
							$_SESSION["ErrorMessage"]="Something went wrong. contact Developer.";
						}
					}else{
						$_SESSION["SuccessMessage"]="Teacher Registration Success!";
						Redirect_to("TeacherLogin.php");
					}
					
				}
				else
				{
					$_SESSION["ErrorMessage"]="Teacher Registration Failed!";
					Redirect_to("TeacherRegistration.php");
				}
			}


						function AddStudent($FirstName,$LastName,$UserName,$Password,$Vkey,$DateTime){
							global $ConnectingDB;
							$mailFunction=true;
							$sqladd="INSERT INTO student (firstname,lastname,email,password,profilephoto,vkey,verified,datetime) ";
							$sqladd.="VALUES (:firsTname,:laStname,:eMail,:paSsword,:profilepHoto,:vkEy,:veRfi,:datetiMe)";
							$stmtadd=$ConnectingDB->prepare($sqladd);
							$stmtadd->bindValue(':firsTname',$FirstName);
							$stmtadd->bindValue(':laStname',$LastName);
							$stmtadd->bindValue(':eMail',$UserName);
							$stmtadd->bindValue(':paSsword',md5($Password));
							$stmtadd->bindValue(':profilepHoto','avatar.png');
							$stmtadd->bindValue(':vkEy',$Vkey);
							$stmtadd->bindValue(':veRfi','0');
							$stmtadd->bindValue(':datetiMe',$DateTime);
							$Execute=$stmtadd->execute();
							if($Execute){
								$subject="Confirmation for CollegeInsight";
								$message="<!DOCTYPE html>
											<html>
											<head>
											<style>
											.button {
											display: inline-block;
											padding: 15px 25px;
											font-size: 30px;
											cursor: pointer;
											text-align: center;
											text-decoration: none;
											outline: none;
											color: white;
											background-color: #00b33c;
											border: none;
											border-radius: 15px;
											box-shadow: 0 9px #4dd2ff;
											}

											.button:hover {background-color: #008000}

											.button:active {
											background-color: #1a1aff;
											box-shadow: 0 5px #666;
											transform: translateY(4px);
											}
											</style>
											</head>
											<body>
											<h2>Hi ".$FirstName." ".$LastName.",</h2>
											<h3> Verify your email for CollegeInsight by click below link. it is only valid for 5 minutes. </h3>
											<a href='http://localhost/CollegeInsight/usEmailVerify.php?vkey=".$Vkey."'>
											<button class='button'>Verify Email</button></a>
											<br><br>
											</body>
											</html>
											Please do not share this link with anyone. if this was not you, contact our support team at http://localhost/collegeinsight/contactUs.php";
								$headers="from: CollegeInsight <collegeinsight.ketan@gmail.com>\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


								if($mailFunction){
									//commented for unable/disable sending email
									if(mail($UserName,$subject,$message,$headers)){
										$_SESSION["SuccessMessage"]="Student Registration Success! Verification mail sent to ".$UserName."";
										Redirect_to("login.php");
									}
									else
									{
										$_SESSION["ErrorMessage"]="Something went wrong. contact Developer.";
									}
								}else{
									$_SESSION["SuccessMessage"]="Student Registration Success! ";
									Redirect_to("login.php");
								}
								
							}
							else
			        {
			          $_SESSION["ErrorMessage"]="Student Registration Failed!";
			          Redirect_to("Registration.php");
			        }
						}

	function TotalClasses(){
		global $ConnectingDB;
		$sql="SELECT COUNT(*) FROM class where tid=$_SESSION[Teacher_Id]";
		$stmt=$ConnectingDB->query($sql);
		$TotalRows=$stmt->fetch();
		$TotalClasses=array_shift($TotalRows);
		echo $TotalClasses;
	}

	function TotalAssignment(){
		global $ConnectingDB;
		$sql="SELECT COUNT(*) FROM assignment where tid=$_SESSION[Teacher_Id]";
		$stmt=$ConnectingDB->query($sql);
		$TotalRows=$stmt->fetch();
		$TotalAssignment=array_shift($TotalRows);
		echo $TotalAssignment;
	}

	function TotalNotification(){

							global $ConnectingDB;
							$sql="SELECT COUNT(*) FROM notification,class where class.id=notification.cid and class.tid=$_SESSION[Teacher_Id]";
							$stmt=$ConnectingDB->query($sql);
							$TotalRows=$stmt->fetch();
							$TotalNotification=array_shift($TotalRows);
							echo $TotalNotification;
	}



		function TotalClassesForStudent(){
			global $ConnectingDB;
			$sql="SELECT COUNT(*) FROM classroom where sid='$_SESSION[User_Id]' AND status='approved'";
			$stmt=$ConnectingDB->query($sql);
			$TotalRows=$stmt->fetch();
			$TotalClasses=array_shift($TotalRows);
			echo $TotalClasses;
		}

		function TotalAssignmentForStudent(){
			global $ConnectingDB;
			#$sql="SELECT COUNT(*) FROM assignment";
			$sql="SELECT COUNT(*) FROM assignment, classroom where assignment.cid=classroom.cid and classroom.sid='$_SESSION[User_Id]'";
			$stmt=$ConnectingDB->query($sql);
			$TotalRows=$stmt->fetch();
			$TotalAssignment=array_shift($TotalRows);
			echo $TotalAssignment;
		}


		function totalStudentInClass($CID){
			global $ConnectingDB;
			$sql="SELECT COUNT(*) FROM classroom where cid=$CID";
			$stmt=$ConnectingDB->query($sql);
			$TotalRows=$stmt->fetch();
			$TotalAssignment=array_shift($TotalRows);
			echo $TotalAssignment;
		}

		function TotalNotificationForStudent(){

								global $ConnectingDB;
								#$sql="SELECT COUNT(*) FROM notification";
								$sql="SELECT COUNT(*) FROM notification, classroom where notification.cid=classroom.cid and classroom.sid='$_SESSION[User_Id]'";
								$stmt=$ConnectingDB->query($sql);
								$TotalRows=$stmt->fetch();
								$TotalNotification=array_shift($TotalRows);
								echo $TotalNotification;
		}

	function ApproveCommentsAccordingtoPost($PostId){
		global $ConnectingDB;
		$sqlApprove="SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
		$stmtApprove=$ConnectingDB->query($sqlApprove);
		$RowsTotalA=$stmtApprove->fetch();
		$TotalA=array_shift($RowsTotalA);
		return $TotalA;
	}

	function DisApproveCommentsAccordingtoPost($PostId){
		global $ConnectingDB;
		$sqlDisApprove="SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
		$stmtDisApprove=$ConnectingDB->query($sqlDisApprove);
		$RowsTotalD=$stmtDisApprove->fetch();
		$TotalD=array_shift($RowsTotalD);
		return $TotalD;
	}

	//getting class detail by id 
	function classDetails($classId)
	{
		global $ConnectingDB;
		
		$sql="SELECT * FROM class where id=$classId";
		$stmt=$ConnectingDB->query($sql);
		while($DataRows=$stmt->fetch()){
					return $DataRows;
		}
	}
	
	//getting teacher detail by teacher id 
	function teacherDetails($teacherId)
	{
		global $ConnectingDB;
		
		$sql="SELECT * FROM teacher where id=$teacherId";
		$stmt=$ConnectingDB->query($sql);
		while($DataRows=$stmt->fetch()){
					return $DataRows;
		}
	}

	//gettting Class Details 
	function classFullDetails($classId)
	{
		global $ConnectingDB;
		
		$sql="SELECT ";
		$sql .= "c.id as cid,c.cname as cname,c.datetime as cdatetime, t.email as temail, t.firstname as tfname, t.lastname as tlname, t.profilephoto as tphoto ";
		$sql .= "FROM class as c,teacher as t ";
		$sql .= "where c.tid=t.id and c.id=$classId";
		$stmt=$ConnectingDB->query($sql);
		while($DataRows=$stmt->fetch()){
					return $DataRows;
		}
	}

	
	//approve assignment
	//disapprove assignment
	
?>
