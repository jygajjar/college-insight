<?php
require_once("Includes/Functions.php");
require_once("Includes/Sessions.php");

$_SESSION["admin_user"]=null;
session_destroy();
Redirect_To("adminPanel.php");
?>
