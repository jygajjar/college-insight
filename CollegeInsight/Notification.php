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
	<title>Notification</title>
</head>
<body>
	
<?php require_once("Includes/studentHeader.php");?>



<section class="container-fluid">
	<div class="row">
		<div class="col-md-8 offset-2" id="teacherClass">
			<div class="card my-2">
				<div class="card-header">
					<div class="row">
						<div class="col-md-11">
							<p class="h3">Notifications</p>
						</div>
					</div>
				</div>
				<div class="card-body" id="studentDetail">

					<?php
						global $ConnectingDB;
						$sql="select n.id as id, n.textcontent as textcontent, n.datetime as datetime,c.id as cid, c.cname as cname,t.id as tid, t.firstname as firstname, t.lastname as lastname, t.profilephoto as profilephoto, cr.status as staus ";
						$sql .= " from notification as n, class as c, teacher as t, classroom as cr ";
						$sql .= " where n.cid=c.id and c.tid=t.id and t.id=cr.tid and cr.cid=c.id and cr.status='approved' and cr.sid='$_SESSION[User_Id]' Order BY n.id DESC";
						$Execute=$ConnectingDB->query($sql);
						$dataFound = false;
						while($DataRows=$Execute->fetch()){
							$aid=$DataRows["id"];
							$tid=$DataRows["tid"];
							$cid=$DataRows["cid"];
							$TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
							$ProfilePic=$DataRows["profilephoto"];
							$ClassName=$DataRows["cname"];
							$TextContent=$DataRows["textcontent"];
							$NotificationDate=$DataRows["datetime"];
							$dataFound = true;
							$readmore=false;
							if(strlen($TextContent)>100){
								$TextContent=substr($TextContent,0,100)."...";
								$readmore=true;
							}
						?>
						<div class="stu_notification">
							<div class="row">
								<div class="col-md-1">
									<a href='Images/<?php echo $ProfilePic?>' target="_blank">
										<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $ProfilePic;?>">
									</a>
								</div>
								<div class="col-md-11">
									<a href='Profile.php?tid=<?php echo $tid;?>' target="_blank"  style="text-decoration:none;color:black;">
										<p class="h3"><?php echo $TeacherName;?></p>
									</a>
									<a href='ClassRoom.php?id=<?php echo $cid;?>&&action=details' style="text-decoration:none;color:black;">
										<p class="h6"><?php echo $ClassName;?></p>
									</a>
									<p class="h6"><?php echo $NotificationDate;?></p>
								</div>
							</div>
							<hr>
							<div class="m-4">
								<p><?php echo $TextContent;?></p>
							</div>

							<?php
							
								if($readmore)
								{
									?>
									<div class="" style="margin-bottom:80px;">
										<a href="FullNotification.php?id=<?php echo $aid?>" style="float:right;">
											<span class="btn btn-info">Read More >></span>
										</a>
									</div>
								<?php
								}?>
						</div>
					<?php }
					
					
					if(!$dataFound){
						?>
						<div class="noData">
							<p class="m-3">No Notification Found</p>
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
