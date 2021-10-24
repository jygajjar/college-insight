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
	<title>ClassRoom</title>
</head>
<body>
	
<?php require_once("Includes/studentHeader.php");?>

	<section class="container-fluid">
		<div class="row">
			<div class="col-md-3 bg-dark" style="min-height:640px;max-height:700px;" class="studentSideBar">
				
				<div class="col-md-12 my-4 ml-3">
				
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white h2 forselectclass" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php 
							if(isset($_GET['id'])){
								$data = classDetails($_GET['id']);
								echo $data['cname'];
							}else{
								echo "Select Class";
								}
							
							?>
						</a>
						<div class="dropdown-menu " aria-labelledby="navbarDropdown">
							<?php
								$sql="SELECT c.id as cid,t.id as tid,c.cname as cname, t.firstname as firstname,t.lastname as lastname ";
								$sql .= "from class as c,teacher as t, classroom as cr ";
								$sql .= " where c.id=cr.cid and cr.tid=t.id and cr.sid='$_SESSION[User_Id]' and cr.status='approved'";
								$Execute=$ConnectingDB->query($sql);
								$dataFound = false;
								while($DataRows=$Execute->fetch()){
									$ClassId=$DataRows["cid"];
									$TeacherId=$DataRows["tid"];
									$ClassName=$DataRows["cname"];
									$TeacherFirstname=$DataRows["firstname"];
									$TeacherLastname=$DataRows["lastname"];
									$dataFound = true;
								?>
									
								<a class="dropdown-item" href="ClassRoom.php?id=<?php echo $ClassId;?>&&action=details"><?php echo $ClassName;?></a>
							<?php } 
							
									
								if(!$dataFound){
									?>
									<a class="dropdown-item disabled" href="#"><?php echo "Empty";?></a>
							<?php
								}
							?>
						</div>
					</li>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=assignment" class="btn btn-dark btn-lg btn-block <?php if($_GET["action"]=="assignment"){echo "active";}?>">
						<i class=""></i>Assignment
					</a>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=subassignment" class="btn btn-dark btn-lg btn-block <?php if($_GET["action"]=="subassignment"){echo "active";}?>">
						<i class=""></i>Submitted Assignment
					</a>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=notification" class="btn btn-dark btn-lg btn-block <?php if($_GET["action"]=="notification"){echo "active";}?>">
						<i class=""></i>Notification
					</a>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=details" class="btn btn-dark btn-lg btn-block <?php if($_GET["action"]=="details"){echo "active";}?>">
						<i class=""></i>More
					</a>
				</div>
		  	</div>



		 
	      <div class="col-md-9"  style="overflow:scroll;max-height:640px;">
		  								<?php
											echo ErrorMessage();
											echo SuccessMessage();
										?>
			<?php
				if(isset($_GET["id"]))
				{
					if(isset($_GET["action"]))
					{
						switch($_GET["action"])
						{
							case "assignment":
								//Assignment details code
							?>
									<div class="row">
										
									<div class="col-md-12" id="teacherClass">
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
													$sql .= " where a.cid=c.id and c.id=cr.cid and c.tid=t.id and cr.sid=$_SESSION[User_Id] and c.id=$_GET[id] and cr.status='approved' and a.id not in (SELECT aid as id FROM std_work WHERE sid=$_SESSION[User_Id]) ";
													
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
														<div class="emptyArea">
															<p class="m-3">No Assignment Found</p>
														</div>	
												<?php
													}
												?>
											</div>
										</div>
									</div>
									<?php
								break;
								case "subassignment":
									//Submitted Assignment details code
								?>
										<div class="row">
											
											<div class="col-md-12" id="teacherClass">
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
													$sql .= " where c.id=cr.cid and c.id=a.cid and sw.aid=a.id and a.tid=t.id and sw.sid=$_SESSION[User_Id] and c.id=$_GET[id]  and cr.status='approved' group by sw.id";
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
																		}elseif($status == 'Pending')
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
																<div class="emptyArea">
																	<p class="m-3">No Submitted Assignment Found</p>
																</div>	
														<?php
															}
														?>
													</div>
												</div>
											</div>
										</div>
										<?php
									break;
							case "notification":
								//Notification details code
								?>
								
									<div class="row">
										<div class="col-md-12" id="teacherClass">
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
														$sql .= " where n.cid=c.id and c.tid=t.id and t.id=cr.tid and cr.cid=c.id and cr.status='approved' and  c.id=$_GET[id] and cr.sid='$_SESSION[User_Id]' Order BY n.id DESC";
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

															$readmore=false;
															if(strlen($TextContent)>100){
																$TextContent=substr($TextContent,0,100)."...";
																$readmore=true;
															}

															$dataFound = true;
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
														<div class="emptyArea">
															<p class="m-3">No Notification Found</p>
														</div>	
												<?php
													}
													
													?>
												</div>
											</div>
										</div>
									</div>
								<?php
								break;
							case "details":
								//Class details code

								global $ConnectingDB;
								$sql="SELECT * FROM class as c,teacher as t where c.tid=t.id and c.id='$_GET[id]'";
								$Execute=$ConnectingDB->query($sql);
			
								while($DataRows=$Execute->fetch()){
									$ClassName=$DataRows["cname"];
									$Created_date=$DataRows["datetime"];
									$TeacherName = $DataRows["firstname"]." ".$DataRows["lastname"];
									
								?>
								
								<div class="row">
									<div class="col-md-12">
										
										<div class="card my-2">
											<div class="card-header">
												<div class="row">
													<div class="col-md-11">
														<p class="h3 "><?php echo $ClassName;?></p>
													</div>
												</div>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-3">
														<p>Teacher Name</p>
														<p>Created date</p>
													</div>
													<div class="col-1">
														<p>:</p>
														<p>:</p>
													</div>
													<div class="col-8">
														<p><?php echo $TeacherName;?></p>
														<p> <?php echo $Created_date;?></p>
													</div>
												</div>
												<div class="col-md-3 float-right mr-2">
													<a href="leaveClass.php?id=<?php echo $_GET['id'];?>" onclick="return confirm('You will lost this class related data .Are you sure to leave class? ');" class="btn btn-danger btn-md btn-block">Leave Class</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
								}

								break;
							default :
								echo "Relax Boys, We Will Fix This";
						}
					}
					else
					{
						//redirect_to('ClassRoom.php?id='.$_GET['id'].'&&action=assignment');
						echo '<p class="h1"> ^^^^^^^^^^  SELECT ^^^^^^^^^^^^</p>';
					}
					
				}
				else
				{
				?>
					
					<div class="emptyArea">
						<p class="m-3">Select Class to See More..</p>
					</div>		
					
				<?php
				}
				?>
	      </div>
	    </div>
	</section>



	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
		$('#year').text(new Date().getFullYear());

		x = $(".forselectclass").text().trim();
		if(x == "Select Class"){
			setInterval(function(){
				$(".forselectclass").toggleClass("text-dark");
			}, 500);
		}
	</script>
</body>
</html>
