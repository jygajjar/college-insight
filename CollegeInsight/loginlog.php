<?php
	require_once("Includes/DB.php");
	require_once("Includes/Functions.php");
	require_once("Includes/Sessions.php");
	$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
		
	if(!isset($_SESSION["admin_user"])){
	    Redirect_to("adminpanel.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>Login Log</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

    <a href="adminpanel.php" class="navbar-brand"><img src="Images/collegeinsight.png" height=60px></a>
    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarcollapseCMS">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a href="adminDashboard.php" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="loginlog.php" class="nav-link">Login Log</a>
        </li>
        <li class="nav-item">
            <a href="adminContact.php" class="nav-link">Contact us</a>
        </li>
      
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="adminLogout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i>Logout</a></li>
    </ul>
    </div>
</div>
</nav>




	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-lg-12">
        <h1 class="h1">LoginLog</h1>
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
					<tr>
						<th>#</th>
            <th>Email</th>
						<th>Password</th>
						<th>IP Address</th>
						<th>Role</th>
						<th>Status</th>
						<th>Datetime</th>
					</tr>
					</thead>
					<?php
					global $ConnectingDB;
					$sql="SELECT * FROM loginlog ORDER BY id desc";
					$stmt=$ConnectingDB->query($sql);
					$Sr=0;
					while($DataRows=$stmt->fetch()){
						$Id=$DataRows["id"];
						$Email=$DataRows["email"];
						$Password=$DataRows["password"];
						$IP=$DataRows["ip"];
						$Role=$DataRows["role"];
						$Status=$DataRows["status"];
						$DateTime=$DataRows["datetime"];
						$Sr++;
						echo "<tbody><tr>";
						echo "<td>".$Sr."</td>";
						echo "<td>".$Email."</td>";
						echo "<td>".$Password."</td>";
						echo "<td>".$IP."</td>";
						echo "<td>".$Role."</td>";
						echo "<td>".$Status."</td>";
						echo "<td>".$DateTime."</td>";
						echo "</tr></tbody>";
					}
					?>
				</table>
			</div>
		</div>









	</section>


	<footer class="bg-dark text-white">
		<div class="container">
			<div class="row">
				<div class="col">
					<p class="lead text-center">Theme By | Ketan Chavda | <span id="year"></span>&copy; ----All right Reserved.</p>
				</div>
			</div>
		</div>
	</footer>
	<div style="height:10px;background:#27aae1;"></div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
		$('#year').text(new Date().getFullYear());
	</script>
</body>
</html>
