<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
	//echo $_SESSION["TrackingURL"];
	Confirm_Login();

    if(isset($_GET["id"])){
		$nId=$_GET["id"];
		global $ConnectingDB;
		$sql="SELECT n.id as id,n.textcontent as textcontent, n.datetime as datetime,c.id as cid,c.cname as cname,t.id as tid, t.profilephoto as profilephoto, t.firstname as firstname, t.lastname as lastname ";
        $sql .=" FROM notification as n, class as c, teacher as t ";
        $sql .= " WHERE n.cid=c.id and c.tid=t.id and n.id='$nId'";
        $Execute=$ConnectingDB->query($sql);
		$DataRows=$Execute->fetch();

		if($Execute){
			$id = $DataRows['id'];
			$textcontent = $DataRows['textcontent'];
			$datetime = $DataRows['datetime'];
			$cid = $DataRows['cid'];
			$cname = $DataRows['cname'];
			$profilephoto = $DataRows['profilephoto'];
			$tid = $DataRows['tid'];
			$tname = $DataRows['firstname']." ".$DataRows['lastname'];
		}else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again ! ";
			Redirect_to("Notification.php");
		}
	}else{
		Redirect_to("Notification.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Notification</title>
</head>
<body>
<?php require_once("Includes/studentHeader.php");?>
	<header class="py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Full Notification</h1>
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

				<div class="card my-2">
					<div class="card-header">
						<div class="row">
							<div class="col-md-1">
								<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $profilephoto;?>">
							</div>
							<div class="col-md-11">
								<a href='Profile.php?tid=<?php echo $tid;?>' target="_blank"  style="text-decoration:none;color:black;">
									<p class="h3 "><?php echo $tname;?></p>
								</a>
								<a href='ClassRoom.php?id=<?php echo $cid;?>&&action=details' style="text-decoration:none;color:black;">
									<p class="h6"><?php echo $cname;?></p>
								</a>
								<p class="h6"><?php echo $datetime;?></p>
							</div>
						</div>
					</div>
					<div class="card-body mx-5" style="min-height:200px;font-size:20px;">
						<p class=""><?php echo $textcontent;?></p>
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
