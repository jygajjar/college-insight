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
			<div class="col-md-3 bg-dark" style="min-height:640px;max-height:700px;" >
				
				<div class="col-md-12 my-4 ml-3">
				
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white h2" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php 
							$data = classDetails($_GET['id']);
							if($data){
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
				
								while($DataRows=$Execute->fetch()){
									$ClassId=$DataRows["cid"];
									$TeacherId=$DataRows["tid"];
									$ClassName=$DataRows["cname"];
									$TeacherFirstname=$DataRows["firstname"];
									$TeacherLastname=$DataRows["lastname"];
								?>
									
								<a class="dropdown-item" href="ClassRoom.php?id=<?php echo $ClassId;?>&&action=details"><?php echo $ClassName;?></a>
							<?php } ?>
						</div>
					</li>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=assignment" class="btn btn-dark btn-lg btn-block">
						<i class=""></i>Assignment
					</a>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=subassignment" class="btn btn-dark btn-lg btn-block">
						<i class=""></i>Submitted Assignment
					</a>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=notification" class="btn btn-dark btn-lg btn-block">
						<i class=""></i>Notification
					</a>
				</div>
				<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
					<a href="ClassRoom.php?id=<?php echo $_GET['id'];?>&&action=details" class="btn btn-dark btn-lg btn-block">
						<i class=""></i>More
					</a>
				</div>
		  	</div>



		 
	      <div class="col-md-9">
			
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
										<?php
										echo ErrorMessage();
										echo SuccessMessage();
									?>
										<div class="col-md-12">
											<?php
											global $ConnectingDB;
											$sql="SELECT c.cname as cname, a.id as id, t.firstname as firstname, t.lastname as lastname, a.aname as description,a.uploaddate as uploaddate , a.lastdate as lastdate,a.amedia as amedia";
											$sql .= " FROM assignment as a,class as c, classroom as cr, teacher as t ";
											$sql .= " where a.cid=c.id and c.id=cr.cid and c.tid=t.id and cr.sid=$_SESSION[User_Id] and c.id=$_GET[id] and cr.status='approved' and a.id not in (SELECT aid as id FROM std_work WHERE sid=$_SESSION[User_Id]) ";
											$Execute=$ConnectingDB->query($sql);

											while($DataRows=$Execute->fetch()){
												$Aid=$DataRows["id"];
												$ClassName=$DataRows["cname"];
												$TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
												$AssignDescription=$DataRows["description"];
												$DateTime=$DataRows["uploaddate"];
												$Deadline=$DataRows["lastdate"];
												$AssignMedia=$DataRows["amedia"];
											
											?>
											<div class="card my-2">
												<div class="card-header bg-primary">
													<div class="row">
														<!--	<div class="col-md-1 mx-2">
																<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo 'avatar.png';//echo $row['profilephoto'];?>">
															</div> -->
															<div class="col-md-9">
																<a href='TeacherProfile.php?Tid=$CreatorName'>
																			<p class="h4 text-white"><?php echo $ClassName;?></p>
																</a>
																<p class="text-white"><?php echo $TeacherName;?></p>
																<p class="text-white"><?php echo $DateTime;?></p>
															</div>
															<div class="col-md-3">
																<a href="SubmitAssignment.php?id=<?php echo $Aid;?>" class="btn btn-danger btn-md btn-block">Submit</a>
															</div>
													</div>
												</div>
												<div class="card-body bg-dark text-white">
													<p><?php echo $AssignDescription;?></p>
													<p><?php echo $AssignMedia;?></p>
												</div>
												
											</div>
										<?php
											}
										?>
										</div>
									</div>
									<?php
								break;
								case "subassignment":
									//Submitted Assignment details code
								?>
										<div class="row">
											<?php
											echo ErrorMessage();
											echo SuccessMessage();
										?>
											<div class="col-md-12">
				<?php
				global $ConnectingDB;
				$sql="SELECT c.cname as cname,sw.id as id, sw.attachment as attachment, sw.description as description, sw.lastdate as lastdate, sw.datetime as submitteddate, sw.status as status, a.aname as aname, a.uploaddate as tuploaddate, a.amedia as amedia, t.firstname as firstname, t.lastname as lastname ";
				$sql .= " FROM assignment as a,class as c, classroom as cr, teacher as t ,std_work as sw";
				$sql .= " where c.id=cr.cid and c.id=a.cid and sw.aid=a.id and a.tid=t.id and sw.sid=$_SESSION[User_Id] and c.id=$_GET[id] and cr.status='approved' group by sw.id";
				$Execute=$ConnectingDB->query($sql);

				while($DataRows=$Execute->fetch()){
					$swid=$DataRows["id"];
					$ClassName=$DataRows["cname"];
					$TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
					$AssignDescription=$DataRows["description"];
					$DateTime=$DataRows["submitteddate"];
					$Deadline=$DataRows["lastdate"];
					$AssignMedia=$DataRows["amedia"];
					$status=$DataRows["status"];
				
				?>
				<div class="card my-2">
					<div class="card-header bg-primary">
						<div class="row">
							<!--	<div class="col-md-1 mx-2">
									<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo 'avatar.png';//echo $row['profilephoto'];?>">
								</div> -->
								<div class="col-md-9">
									<a href='TeacherProfile.php?Tid=$CreatorName'>
												<p class="h4 text-white"><?php echo $ClassName;?></p>
									</a>
									<p class="text-white"><?php echo $TeacherName;?></p>
									<p class="text-white"><?php echo $DateTime;?></p>
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
									elseif($status == 'rejected')
									{
										?>
										<div class="col-md-3">
										<p  class="btn btn-danger btn-md btn-block">Rejected</p>
										</div>
										<?php
									}elseif($status == 'pending')
									{
										?>
										<div class="col-md-3">
										<p  class="btn btn-info btn-md btn-block">Pending</p>
										</div>
										<?php
									}
								?>
								
								
							</div>
						</div>
						<div class="card-body bg-dark text-white">
							<p><?php echo $AssignDescription;?></p>
							<p><?php echo $AssignMedia;?></p>
						</div>
					
					</div>
					<?php
						}
					?>
				</div>
			</div>
										</div>
										<?php
									break;
							case "notification":
								//Notification details code
								?>
								
								<div class="row">
									<div class="col-md-12">
										<?php
										global $ConnectingDB;
										$sql="select n.id as id, n.textcontent as textcontent, n.datetime as datetime, c.cname as cname, t.firstname as firstname, t.lastname as lastname, t.profilephoto as profilephoto, cr.status as staus ";
										$sql .= " from notification as n, class as c, teacher as t, classroom as cr ";
										$sql .= " where n.cid=c.id and c.tid=t.id and t.id=cr.tid and cr.sid='$_SESSION[User_Id]' and c.id=$_GET[id]";
										$Execute=$ConnectingDB->query($sql);

										while($DataRows=$Execute->fetch()){

											$aid=$DataRows["id"];
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
										?>
										<div class="card my-2">
											<div class="card-header bg-primary">
												<a href='TeacherProfile.php?Tid=$TeacherId'>
												<div class="row">
													<div class="col-md-1">
														<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $ProfilePic;?>">
													</div>
													<div class="col-md-11">
														<p class="h3 text-white"><?php echo $TeacherName;?></p>
														<p class="h6 text-white"><?php echo $ClassName;?></p>
														<p class="h6 text-white"><?php echo $NotificationDate;?></p>
													</div>
												</div>
											</a>
											</div>
											<div class="card-body bg-dark text-white">
												<p><?php echo $TextContent;?></p>

												<?php
						
													if($readmore)
													{
														?>
														
														<a href="FullNotification.php?id=<?php echo $aid?>" style="float:right;">
															<span class="btn btn-info">Read More >></span>
														</a>
														
														<?php
													}
												
												?>

											</div>
											
											<!--<div class="card-footer bg-dark">
												<form action="Comment.php" method="post">
													<textarea class="textarea" name="Comment" rows="3" cols="35" placeholder="Add Comment"></textarea>
													<a class="btn btn-primary">Send</a>
												</form>
											</div>-->
										</div>
									<?php
									}
									?>
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
											<div class="card-header bg-primary">
												<a href='TeacherProfile.php?Tid=$TeacherId'>
												<div class="row">
													<div class="col-md-11">
														<p class="h3 text-white"><?php echo $ClassName;?></p>
													</div>
												</div>
											</a>
											</div>
											<div class="card-body bg-dark text-white">
												<p>Teacher Name : <?php echo $TeacherName;?></p>
												<p>Created date : <?php echo $Created_date;?></p>
												<p>Total student : <?php echo "n";?></p>
												<p>Total Class : <?php echo "n";?></p>
												<p>Total Assignment : <?php echo "n";?></p>
												<p>Total Notification : <?php echo "n";?></p>
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
					echo '<p class="h3 col-4 offset-4 mt-5">Select any subject to see more detail.</p>';
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
	</script>
</body>
</html>
