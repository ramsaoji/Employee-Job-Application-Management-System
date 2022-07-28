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

$category_id = $_POST["category_id"];

$delsql= "DELETE FROM `categories` WHERE category_id='$category_id' ";


mysqli_query($con,$delsql);


?>

<?php 

ob_end_flush();
}
?>