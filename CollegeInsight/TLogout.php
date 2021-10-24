<?php
require_once("Includes/Functions.php");
require_once("Includes/Sessions.php");

$_SESSION["Teacher_Id"]=null;
$_SESSION["TeacherEmail"]=null;
$_SESSION["TeacherFirstName"]=null;

session_destroy();
Redirect_To("index.php");
?>
