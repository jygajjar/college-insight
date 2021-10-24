	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

		<div class="container">

			<a href="index.php" class="navbar-brand"><img src="Images/collegeinsight.png" height=60px></a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarcollapseCMS">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i>  My Profile</a>
				</li>
				<li class="nav-item">
					<a href="StudentDashboard.php" class="nav-link">Dashboard</a>
				</li>
				<li class="nav-item">
					<a href="ClassRoom.php" class="nav-link">Class</a>
				</li>
				<li class="nav-item">
					<a href="Notification.php" class="nav-link">Notification</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="Assignment.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Assignment
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item " href="Assignment.php">Pending Assignment</a>
						<a class="dropdown-item" href="subAssignment.php">Submitted Assignment</a>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i>Logout</a></li>
			</ul>
			</div>
		</div>
	</nav>