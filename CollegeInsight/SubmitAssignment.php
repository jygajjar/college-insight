<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	Confirm_Login();

	if(isset($_POST["Submit"])){
		$u_id=$_SESSION["User_Id"];
		$Aid=$_POST["aid"];
		$AssignDescription=$_POST["AssignDescription"];
		$LastDate=$_POST["lastdate"];
		$Image=$_FILES["Image"]["name"];
		$Target="Images/".basename($Image);
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    if(CheckAssignmentExistOrNot($Aid,$u_id))
    {
      $_SESSION["ErrorMessage"]="Assignment Exist !";
      Redirect_to("Assignment.php");
    }
    else {
      $sql="INSERT INTO std_work(aid,sid,attachment,description,lastdate,datetime,status)";
			$sql.="VALUES(:aiD,:siD,:attAchment,:deScription,:lastdAte,:datetIme,:staTus)";
			$stmt=$ConnectingDB->prepare($sql);
			$stmt->bindValue(':aiD',$Aid);
			$stmt->bindValue(':siD',$u_id);
			$stmt->bindValue(':attAchment',$Image);
			$stmt->bindValue(':deScription',$AssignDescription);
			$stmt->bindValue(':lastdAte',$LastDate);
			$stmt->bindValue(':datetIme',$DateTime);
			$stmt->bindValue(':staTus',"Pending");
			$Execute=$stmt->execute() or die(print_r($stmt->errorInfo(), true));
			move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

			if($Execute){
				$_SESSION["SuccessMessage"]="Assignment Added Successfully";
				Redirect_to("Assignment.php");
			}else{
				$_SESSION["ErrorMessage"]="1Something went wrong.Try Again !";
				Redirect_to("SubmitAssignment.php?id=$Aid");
			}

    }


		}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Submit Assignment</title>
</head>
<body>
  
	<?php require_once("Includes/studentHeader.php");?>

	<header class=" py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1><i class="fas fa-edit" style="color:#27aae1;"></i>Submit Assignment</h1>
				</div>
			</div>
		</div>
	</header>



	<section class="container py-2 mb-4">
		<div class="row">
			<div class="offset-lg-1 col-lg-10" style="min-height:400px;">
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
				<form class="" action="SubmitAssignment.php" method="post" id="" enctype="multipart/form-data">
					<div class="card  mb-3">
						<div class="card-body ">
              <?php
      				global $ConnectingDB;
      				$sql="SELECT a.amedia as amedia,a.lastdate as lastdate,a.uploaddate as uploaddate,a.id as id,a.cid as cid,a.tid as tid,a.aname as aname,a.amedia as amedia,c.cname as cname FROM assignment as a,class as c where a.cid=c.id and a.id='$_GET[id]' ORDER BY id desc";
      				$Execute=$ConnectingDB->query($sql);

      				if($DataRows=$Execute->fetch()){
      					$Aid=$DataRows["id"];
      					$Cid=$DataRows["cid"];
						$ClassName=$DataRows["cname"];
      					$TeacherId=$DataRows["tid"];
      					$AssignQDescription=$DataRows["aname"];
      					$DateTime=$DataRows["uploaddate"];
      					$Deadline=$DataRows["lastdate"];
      					$AssignMedia=$DataRows["amedia"];
      				}?>
              <div class="row">
                <input type="hidden" value="<?php echo $Deadline;?>" name="lastdate" />
                  <input type="hidden" value="<?php echo $Aid;?>" name="aid" />
  								<div class="col-md-1 mx-2">
  									<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo 'avatar.png';//echo $row['profilephoto'];?>">
  								</div>
  								<div class="col-md-7">
									<a href='ClassRoom.php?id=<?php echo $Cid;?>&&action=details' style="text-decoration:none;color:black;">
										<p class="h4"><?php echo $ClassName;?></p>
									</a>
  									<p class=""><?php echo $DateTime;?></p>
  								</div>
  						</div>
			  
			  <div class="form-group m-4">
				<p><?php echo $AssignQDescription;?></p>
				<p><a href="Images/<?php echo $AssignMedia;?>" target="_blank" class="attachment" style="text-decoration:none;"><?php echo $AssignMedia;?></a></p>
	 		  </div>
              <div class="form-group">
								<label for="Post"><span class="FieldInfo">Assignment Description:</span></label>
								<textarea class="form-control" id="Post" name="AssignDescription" rows="4" cols="80"></textarea>
							</div>
							<div class="form-group">
								<div class="custom-file">
									<input class="custom-file-input" type="file" name="Image" id="imageSelect"  value="" required>
									<label for="imageSelect" class="custom-file-label">Select Attachment</label>
								</div>
							</div>
							<div class="row" >
								<div class="col-lg-6 mb-2">
									<a href="Assignment.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Assignment</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="Submit" class="btn btn-success btn-block">
										<i class="fas fa-check"></i>Submit
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
		$('#year').text(new Date().getFullYear());
		$('.custom-file-input').on('change',function(){
			var x = this.value.replace(/.*(\/|\\)/,'');
			$('.custom-file-label').html(x);
		});
	</script>
</body>
</html>
