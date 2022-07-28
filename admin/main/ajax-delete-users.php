<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
ob_start();	
?>

<?php

$user_id = $_POST["user_id"];

$delsql= "DELETE FROM `login` WHERE login_id='$user_id' ";


mysqli_query($con,$delsql);


?>

<?php 

ob_end_flush();
}
?>