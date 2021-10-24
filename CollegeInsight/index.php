<!DOCTYPE html>
<html>
<head>
<?php require_once("Includes/incFile.php");?>
	<title>CollegeInsight</title>
	<style>
		body{
			color:white;
		}
	</style>
</head>
<body class="home">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

<div class="container">

	<a href="index.php" class="navbar-brand"><img src="Images/collegeinsight.png" height=60px></a>
<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarcollapseCMS">
	<ul class="navbar-nav mr-auto">
		<!--		<li class="nav-item">
					<a href="#home" class="nav-link">Home</a>
				</li>
				<li class="nav-item">
					<a href="#aboutus" class="nav-link">About us</a>
				</li>
				<li class="nav-item">
					<a href="#mission" class="nav-link">Mission</a>
				</li>
			-->	
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item"><a href="login.php" class="btn btn-success">Login</a></li>
			</ul>
            <ul class="navbar-nav">
				<li class="nav-item"><a href="contactUs.php" class="btn btn-info ml-2">Contact us</a></li>
			</ul>
	</div>
</div>
</nav>

	<div class="col-8 offset-2" style="height:450px;" >   


   		<p class="h1" id="home" style="margin-top:200px;" >Welcome to CollegeInsight,</p>
		<p class="h3 mt-3">
			CollegeInsight  is a free collaboration tool for teachers and students.Using College insight, students and teachers can reach out 
to one another and connect by sharing ideas, problems, and helpful tips.
		</p>




   		<p class="h1"  id="aboutus" style="margin-top:200px;" >About us,</p>
		<p class="h3 mt-3">
		College insight is an 
educational website that takes the ideas of a social network and refines them and makes 
it appropriate for a classroom. 
		</p>




<p class="h1"  id="mission" style="margin-top:200px;" >Mission,</p>
<p class="h3 mt-3">
College insight is 
an educational network that aims at providing teachers with tools to help them connect 
and communicate with their students. Via the College insight website, teachers can share 
content, texts, videos, homework and assignments with their students online.
</p>


</div>


	<script>
		$('#year').text(new Date().getFullYear());
		
	</script>
</body>
</html>
