<?php
require_once("Includes/Functions.php");
require_once("Includes/Sessions.php");

$_SESSION["User_Id"]=null;
$_SESSION["UserEmail"]=null;
$_SESSION["UserFirstName"]=null;

session_destroy();
Redirect_To("index.php");
?>
