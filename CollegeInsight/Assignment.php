<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	//echo $_SESSION["TrackingURL"];
	Confirm_Login();
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Assignment</title>
</head>
<body>
	
<?php require_once("Includes/studentHeader.php");?>

<section class="container-fluid mb-4">
	<div class="row">
		<div class="col-md-8 offset-2" id="teacherClass">
			<div class="card my-2">
				<div class="card-header">
					<div class="row">
						<div class="col-md-11">
							<p class="h3">Assignment</p>
						</div>
					</div>
				</div>
				<div class="card-body" id="studentDetail">

					<?php
						global $ConnectingDB;
						$sql="SELECT c.id as cid, c.cname as cname, a.id as id,t.id as tid, t.firstname as firstname, t.lastname as lastname,a.title as atitle,  a.aname as description,a.uploaddate as uploaddate , a.lastdate as lastdate,a.amedia as amedia";
						$sql .= " FROM assignment as a,class as c, classroom as cr, teacher as t ";
						$sql .= " where a.cid=c.id and c.id=cr.cid and c.tid=t.id and cr.sid=$_SESSION[User_Id] and cr.status='approved' and a.id not in (SELECT aid as id FROM std_work WHERE sid=$_SESSION[User_Id]) ";
						
						$Execute=$ConnectingDB->query($sql);
						$dataFound = false;
						while($DataRows=$Execute->fetch()){
							$Aid=$DataRows["id"];
							$Cid=$DataRows["cid"];
							$Tid=$DataRows["tid"];
							$ClassName=$DataRows["cname"];
							$TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
							$AssignDescription=$DataRows["description"];
							$DateTime=$DataRows["uploaddate"];
							$Deadline=$DataRows["lastdate"];
							$AssignMedia=$DataRows["amedia"];
							$AssignName=$DataRows["atitle"];
							
							$today = new DateTime();
							$date = new DateTime($Deadline);
							$interval = $date->diff($today);
							$isRegular = $interval->invert;
							$dataFound = true;
					?>

					<div class="pendingAssignment">
						<div class="row">
							<div class="col-md-9">
								<a href='ClassRoom.php?id=<?php echo $Cid;?>&&action=details' style="text-decoration:none;color:black;">
									<p class="h3"><?php echo $ClassName;?></p>
								</a>
								<a href='Profile.php?tid=<?php echo $Tid;?>' target="_blank"  style="text-decoration:none;color:black;">
									<p class="h6"><?php echo $TeacherName;?></p>
								</a>
								<?php
									if($isRegular)
									{
										echo '<p class="h6">Due Date : '.$Deadline.'</p>';
									}else{
										echo '<p class="h6" style="color:red;">Due Date : '.$Deadline.'</p>';
									}
								?>
							</div>
							<div class="col-md-3 float-right">
								<a href="SubmitAssignment.php?id=<?php echo $Aid;?>" class="btn btn-primary btn-md btn-block">Submit<?php if(!$isRegular){echo " in Late";}?></a>
							</div>
						</div>
						<hr>
						<div class="">
							<p class="h5"><?php echo $AssignName;?></p>
						</div>
						<div class="m-4">
							<p><?php echo $AssignDescription;?></p>
							<p><a href="Images/<?php echo $AssignMedia;?>" target="_blank" class="attachment" style="text-decoration:none;"><?php echo $AssignMedia;?></a></p>
						</div>
					</div>					
					
					<?php
						}

						if(!$dataFound){
							?>
							<div class="noData">
								<p class="m-3">No Assignment Found</p>
							</div>	
					<?php
						}
					?>
				</div>
			</div>
      	</div>
	</div>
</section>



	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
		$('#year').text(new Date().getFullYear());
	</script>
</body>
</html>
