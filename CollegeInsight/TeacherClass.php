<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	//echo $_SESSION["TrackingURL"];
	Confirm_Teacher_Login();
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Class</title>
</head>
<body class="">
<?php require_once("Includes/header.php");?>
<?php
if(isset($_GET['cid'])){?>
	<section class="container-fluid">
	
	<div class="row">
      <div class="col-md-3 bg-dark " style="min-height:640px;max-height:700px;" >
	  
	  	<div class="col-md-12 my-4 ml-3">
		  	
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle text-white h2" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php 
					$data = classDetails($_GET['cid']);
					echo $data['cname'];
					?>
				</a>
				<div class="dropdown-menu " aria-labelledby="navbarDropdown">
					<?php
						global $ConnectingDB;
						$sql="SELECT * FROM class where tid=$_SESSION[Teacher_Id] ORDER BY id desc";
						$Execute=$ConnectingDB->query($sql);
						$SrNo=0;

						while($DataRows=$Execute->fetch()){
							$ClassId=$DataRows["id"];
							$ClassDate=$DataRows["datetime"];
							$ClassName=$DataRows["cname"];
							$CreatorName=$DataRows["tid"];
							$SrNo++;
						?>
							
						<a class="dropdown-item" href="TeacherClass.php?cid=<?php echo $ClassId;?>&&action=classDetails"><?php echo $ClassName;?></a>
					<?php } ?>
				</div>
			</li>
		</div>
		<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
		<a href="TeacherClass.php?cid=<?php echo $_GET['cid'];?>&&action=classDetails" class="btn btn-dark btn-lg btn-block">
						<i class=""></i><?php echo "Class Details";?>
					</a>
		</div>
		<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
		<a href="TeacherClass.php?cid=<?php echo $_GET['cid'];?>&&action=studentlist" class="btn btn-dark btn-lg btn-block">
						<i class=""></i><?php echo "Student List";?>
					</a>
		</div>
		<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
		<a href="TeacherClass.php?cid=<?php echo $_GET['cid'];?>&&action=assignment" class="btn btn-dark btn-lg btn-block">
						<i class=""></i><?php echo "Assignment List";?>
					</a>
		</div>
		<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
		<a href="TeacherClass.php?cid=<?php echo $_GET['cid'];?>&&action=notificationlist" class="btn btn-dark btn-lg btn-block">
						<i class=""></i><?php echo "Notificatioon List";?>
					</a>
			
		</div>
		<div class="col-md-12 my-3" style="min-height:50px;background-color:;">
		<a href="TeacherClass.php?cid=<?php echo $_GET['cid'];?>&&action=submittedassignment" class="btn btn-dark btn-lg btn-block">
						<i class=""></i><?php echo "Submited List";?>
					</a>
			
		</div>
      </div>
      <div class="col-md-9" id="teacherClass" style="overflow:scroll;max-height:640px;">
		<?php
			if(isset($_GET["action"]))
			{
				switch($_GET["action"])
				{
					case "classDetails":
						//class details code
						?>
							<div class="card my-2">
								  <div class="card-header">
												<div class="row">
													<div class="col-md-11">
														<p class="h3"><?php echo $data['cname'];?></p>
														
													</div>
												</div>
								  </div>
								  <div class="card-body" id="studentDetail">
									  <div class="row">
										<div class="col-3">
											<p>Class Id</p>
											<p>Creator Name</p>
											<p>Creator Email</p>
											<p>Created at</p>
											<p>Total Student</p>
										</div>
										<div class="col-1">
											<p>:</p>
											<p>:</p>
											<p>:</p>
											<p>:</p>
											<p>:</p>
										</div>
										<div class="col-8">
											<div class="row">
											<p id="classCode"><?php echo $_GET['cid'];?></p>
												<p class="btn btn-xm btn-outline-dark ml-2" id="copyBtn" onclick="copyFunction()">Copy</p>
											<span class="small " style="font-size:13px;">*Share class id with student to join class</span>
										</div>
											
											<p><?php 
												$cdata = classFullDetails($_GET['cid']);
												echo $cdata['tfname']." ".$cdata['tlname'];
												?></p>
											
											
											<p><?php 
												$cdata = classFullDetails($_GET['cid']);
												echo $cdata['temail'];
												?></p>
											<p><?php 
											echo $cdata['cdatetime'];
											?></p>
											<p><?php 
											echo totalStudentInClass($_GET['cid']);
											?></p>
										</div>
									
								</div>
							<?php
						break;
					case "studentlist":
						//student list code
						?>
							<div class="card my-2 p-2">
								  <div class="card-header mb-2">
												<div class="row">
													<div class="col-md-9 ">
														<p class="h2">
															Student List
														<p>
													</div>
													<div class="col-md-3">
														<a href="AddStudentToClass.php" class="btn btn-success btn-block">
															<i class="fas fa-plus"></i>Add New
														</a>
													</div>
												</div>
								  </div>
								  <?php 
										
										global $ConnectingDB;
		
										$sql="SELECT * FROM classroom,student where classroom.sid=student.id and classroom.cid=$data[id]";
										$Execute=$ConnectingDB->query($sql);
										$SrNo=1;
										$dataFound = false;
										while($DataRows=$Execute->fetch()){
											$dataFound = true;
											?>
											
											<a class="h3 text-dark " style="text-decoration:none;" href="Profile.php?sid=<?php echo $DataRows['id'];?>" target="_blank">
											<div class="card-body  mb-2 " id="studentList">
												<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $DataRows['profilephoto'];?>">
																<?php echo $DataRows["firstname"]." ".$DataRows["lastname"];?>					
																</div>
													</a>	
											<?php
											$SrNo++;
										
										}
										if(!$dataFound){
											?>
											<div class="emptyArea">
												<p class="m-3">No Student Found</p>
											</div>	
									<?php
										}



										//static data start

										/*
										while($SrNo<10){
											?>
											
											<a class="h3 text-dark " style="text-decoration:none;" href="Profile.php?sid=#" target="_blank">
											<div class="card-body  mb-2 " id="studentList">
												<img class='rounded-circle' style="height:50px;width:50px;" src="images/avatar.png">
																<?php echo "User ".$SrNo;?>					
																</div>
													</a>	
											<?php
											$SrNo++;
										
										}

										//static data end
										*/
									
										?>
									
								</div>
							<?php
						break;
					case "assignment":
						//assignment list code
						?>
							
							<div class="card my-2 p-2">
								  <div class="card-header mb-2">
												<div class="row">
												<div class="col-md-9 ">
														<p class="h2">
														Assignment
														<p>
													</div>
													<div class="col-md-3">
														<a href="TeacherAssignment.php" class="btn btn-success btn-block">
															<i class="fas fa-plus"></i>Add New
														</a>
													</div>
												</div>
								  </div>
								  <?php 
										
										global $ConnectingDB;
		
										$sql="SELECT * FROM assignment where tid=$_SESSION[Teacher_Id] and cid=$_GET[cid] ORDER BY id desc";
										$Execute=$ConnectingDB->query($sql);
										$SrNo=1;
										$dataFound = false;
										while($DataRows=$Execute->fetch()){
											$dataFound = false;
											?>
											<div class="card-body mb-2" id="assignmentList">
													<div class="row">
														<div class="col-md-11">
															<p class="h4 "><?php echo $DataRows["title"];?></p>
															<p class=""><?php echo $DataRows["uploaddate"];?></p>
														</div>
													</div><hr>

													<div class="row">
														<div class="col-md-11">
															<p class="">Due Date : <?php echo $DataRows["lastdate"];?>
															</p>
														</div>
													</div>
													<?php
														if($DataRows["aname"]){
														?>
														<div class="row">
															<div class="col-md-11">
																<p class="">Assignment Description : 
																	<div class="m-4">
																		<?php echo $DataRows["aname"];?>
																	</div>
																</p>
															</div>
														</div>	
														<?php
														}
													?>
													
													<?php 
														if($DataRows["amedia"]){
														?>
														<div class="row">
															<div class="col-md-11">
																<p class=" ">Attatchment : 
																	<div class="m-4">
																	<a href="Images/<?php echo $DataRows['amedia'];?>" class="attachment" target="_blank" style="text-decoration:none;"><?php echo $DataRows['amedia'];?></a>
																	</div>
																</p>
															</div>
														</div>
														<?php
														}
													?>
													
													<hr>
													<div class="row">
													<div class="col-md-3 mb-2">
														<a href="DeleteAssignment.php?id=<?php echo $DataRows["id"];?>&&c=<?php echo $DataRows["cid"];?>" class="btn btn-danger btn-block">
															<i class="fas fa-trash-alt"></i></i>Delete
														</a>
													</div>
													<div class="col-md-3 mb-2">
														<a href="EditAssignment.php?id=<?php echo $DataRows["id"];?>" class="btn btn-primary btn-block">
															<i class="fas fa-edit"></i>Edit
														</a>
													</div>
												</div>
											</div>
											
											<?php
											$SrNo++;
										
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
							<?php
						break;
					case "notificationlist":
						//notification list code
						?>
							<div class="card my-2 p-2" >
								  <div class="card-header mb-2">
												<div class="row">
													<div class="col-md-9 ">
														<p class="h2 ">
															Notification
														</p>
													</div>
													<div class="col-md-3">
														<a href="TeacherNotification.php" class="btn btn-success btn-block">
															<i class="fas fa-plus"></i>Add New
														</a>
													</div>
												</div>
								  </div>
								  <?php 
										
										global $ConnectingDB;
		
										$sql="SELECT * FROM notification where cid=$_GET[cid] ORDER BY id desc";
										$Execute=$ConnectingDB->query($sql);
										$SrNo=1;
										$dataFound = false;
										while($DataRows=$Execute->fetch()){
											$dataFound = true;
											?>
											<div class="card-body mb-2" id="assignmentList">
													<div class="row">
														<div class="col-md-11 ml-2">
															<p class="h4"><?php echo $data['cname']?></p>
															<p class=""><?php echo $DataRows["datetime"];?></p>
														</div>
													</div>
													<hr>
													<div class="row">
														<div class="col-md-11 mx-4">
															<p class=""><?php echo $DataRows["textcontent"];?></p>
														</div>
													</div>
													<hr>
													<div class="row">
													<div class="col-md-3 mb-2">
														<a href="deleteNotification.php?id=<?php echo $DataRows["id"];?>&&c=<?php echo $DataRows["cid"];?>" class="btn btn-danger btn-block">
															<i class="fas fa-trash-alt"></i></i>Delete
														</a>
													</div>
													<div class="col-md-3 mb-2">
														<a href="editNotification.php?id=<?php echo $DataRows["id"];?>" class="btn btn-primary btn-block">
															<i class="fas fa-edit"></i>Edit
														</a>
													</div>
												</div>
											</div>
											
											<?php
											$SrNo++;
										
										}
										
										if(!$dataFound){
											?>
											<div class="emptyArea">
												<p class="m-3">No Notification Found</p>
											</div>	
									<?php
										}
										?>
									
								</div>
							<?php
						break;
					case "submittedassignment":
						//submitted assignment list code
						?>
							<div class="card my-2 p-2 ">
								  <div class="card-header mb-2">
												<div class="row">
													<div class="col-md-9 ">
														<p class="h2">
															Submitted Assignment
														</p>
													</div>
													
												</div>
								  </div>
								  <?php 
										
										global $ConnectingDB;
		
										$sql="SELECT sw.id as id, sw.attachment as sattachment, sw.description as swdescription, sw.lastdate as lastdate, sw.datetime as datetime, sw.status as sstatus, a.aname as aname,a.title as title, a.uploaddate as auploaddate, a.lastdate as alastdate, a.amedia as amedia,s.id as sid, s.firstname as firstname, s.lastname as lastname, s.profilephoto as profilephoto,c.cname as classname, c.id as cid";
										$sql .= " FROM std_work as sw, assignment as a, student as s, class as c ";
										$sql .= " where a.id=sw.aid and a.cid=c.id and s.id=sw.sid and a.cid=$_GET[cid] and a.tid=$_SESSION[Teacher_Id]";
										$Execute=$ConnectingDB->query($sql);
										$SrNo=1;
										$dataFound = false;
										while($DataRows=$Execute->fetch()){

											$dateTime = new DateTime($DataRows['datetime']);
											$SubDate = $dateTime->format('Y-m-j');
											$date1 = new DateTime($SubDate); 
											$date2 = new DateTime($DataRows['lastdate']); 
											$interval = $date2->diff($date1);
											$isRegular = $interval->invert;
											$dataFound= true;
											?>
											<div class="card-body  mb-2" id="assignmentList">
											<a href="Profile.php?sid=<?php echo $DataRows['sid'];?>" target="_blank" class="text-dark" style="text-decoration:none;">
													<div class="row mb-2">
														<div class="col-md-1">
															<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $DataRows['profilephoto'];?>">
														</div>
														<div class="col-md-7 float-right">
															<?php echo "<h3>".$DataRows['firstname']." ".$DataRows['lastname']."</h3>";?>
															<?php echo $DataRows['datetime'];?><?php if(!$isRegular){echo "<span class='small text-danger'>*Late Handed , Due Date : ".$DataRows['lastdate']."</span>";}?>
														</div>
														<div class="col-md-3 ml-5 md-4 float-right">
														</div>
													</div>
													</a>
													<hr>
													<div class="row">
														<div class="col-md-11">
															<p class="h4"><?php echo $DataRows['title'];?></p>
														</div>
													</div>
													
													<div class="row mx-3">
														<div class="col-md-11">
															<p class=""><?php echo $DataRows['aname'];?></p>
														</div>
													</div>
													<div class="row mx-3">
														<div class="col-md-11">
															<p class=" "><a href="Images/<?php echo $DataRows['amedia'];?>" target="_blank" class="attachment" style="text-decoration:none;"><?php echo $DataRows['amedia'];?></a></p>
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-11">
															<p class="">Student Submitted :</p>
														</div>
													</div>
													<div class="row mx-3">
														<div class="col-md-11">
															<p class=""><?php echo $DataRows['swdescription'];?></p>
														</div>
													</div>
													<div class="row mx-3">
														<div class="col-md-11">
															<p class=""> <a href="Images/<?php echo $DataRows['sattachment'];?>" target="_blank" class="attachment" style="text-decoration:none;"><?php echo $DataRows['sattachment'];?></a></p>
														</div>
													</div>
													<div class="row">
														<div class="col-md-11">
															<p class=" ">Status : <?php echo $DataRows['sstatus'];?></p>
														</div>
													</div>
													<div class="row">
													
													<div class="col-md-3 mb-2">
														<a href="disapproveWork.php?wid=<?php echo $DataRows['id'];?>&&c=<?php echo $DataRows['cid'];?>" class="btn btn-warning btn-block">
															<i class="fas fa-"></i></i>Disapprove
														</a>
													</div>
													<div class="col-md-3 mb-2">
														<a href="approveWork.php?wid=<?php echo $DataRows['id'];?>&&c=<?php echo $DataRows['cid'];?>" class="btn btn-success btn-block">
															<i class="fas fa-"></i></i>Approve
														</a>
													</div>
												</div>
											</div>
											
											<?php
											$SrNo++;
										
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
							<?php
						break;
					default :
						echo "";
				}
			}
		?>
      </div>
	</div>
</section>
		<?php
		}
		else
		{
			echo'<h1 style="color:red;margin-top:100px;margin-left:450px;">Access Denied</h1>';
		}
		
		
		
		?>
			


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
		$('#year').text(new Date().getFullYear());

		function copyFunction(element) {
                    var range = document.createRange();
					var copyText = document.getElementById("classCode");
                    range.selectNode(copyText);
                    window.getSelection().removeAllRanges(); // clear current selection
                    window.getSelection().addRange(range); // to select text
                    document.execCommand("copy");
                    window.getSelection().removeAllRanges();// to deselect
					$('#copyBtn').html("Copied");
                }
		
	</script>
</body>
</html>