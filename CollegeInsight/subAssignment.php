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
							<p class="h3">Submitted Assignment</p>
						</div>
					</div>
				</div>
				<div class="card-body" id="studentDetail">

                <?php
				global $ConnectingDB;
				$sql="SELECT c.id as cid, c.cname as cname,sw.id as id, sw.attachment as attachment, sw.description as description, sw.lastdate as lastdate, sw.datetime as submitteddate, sw.status as status, a.aname as aname, a.uploaddate as tuploaddate,a.title as atitle, a.amedia as amedia,t.id as tid, t.firstname as firstname, t.lastname as lastname ";
				$sql .= " FROM assignment as a,class as c, classroom as cr, teacher as t ,std_work as sw";
				$sql .= " where c.id=cr.cid and c.id=a.cid and sw.aid=a.id and a.tid=t.id and sw.sid=$_SESSION[User_Id] and cr.status='approved' group by sw.id";
				$Execute=$ConnectingDB->query($sql);
				$dataFound = false;
				while($DataRows=$Execute->fetch()){
					$swid=$DataRows["id"];
					$Cid=$DataRows["cid"];
					$Tid=$DataRows["tid"];
					$ClassName=$DataRows["cname"];
					$TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
					$AssignDescription=$DataRows["description"];
					$DateTime=$DataRows["submitteddate"];
					$Deadline=$DataRows["lastdate"];
					$AssignMedia=$DataRows["amedia"];
					$SAssignMedia=$DataRows["attachment"];
					$AssignName=$DataRows["atitle"];
					$status=$DataRows["status"];

					$dateTime = new DateTime($DateTime);
					$SubDate = $dateTime->format('Y-m-j');
					$date1 = new DateTime($SubDate); 
					$date2 = new DateTime($Deadline); 
					$interval = $date2->diff($date1);
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
								<p class=""><?php echo $DateTime;?><?php if(!$isRegular){ echo "<span class='small text-danger'>*Late Handed</span>"; }?></p>
							</div>
                            
								<?php
									if($status == 'approved')
									{
										?>
										<div class="col-md-3">
										<p  class="btn btn-success btn-md btn-block">Approved</p>
										</div>
										<?php
									}
									elseif($status == 'Pending')
									{
										?>
										<div class="col-md-3">
										<p  class="btn btn-info btn-md btn-block">Pending</p>
										</div>
										<?php
									}elseif($status == 'disapproved')
									{
										?>
										
										<div class="col-md-3">
											<p  class="btn btn- btn-md btn-block">Disapproved</p>
											<a href="undoAssignment.php?id=<?php echo $swid;?>&&cid=<?php echo $Cid;?>" class="btn btn-danger btn-block">Delete</a>
										</div>
										<?php
									}
								?>
								
						</div>
						<hr>
						<div class="">
							<p class="h5"><?php echo $AssignName;?></p>
						</div>
						<div class="m-4">
							<p><?php echo $AssignDescription;?></p>
							<p><a href="Images/<?php echo $SAssignMedia;?>" target="_blank" class="attachment" style="text-decoration:none;"><?php echo $SAssignMedia;?></a></p>
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
