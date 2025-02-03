<?php 

include '../admin_classes/config.php';


$faculty_id = $_POST['faculty_id'];
$password = $_POST['password'];


$query = $connect->prepare("UPDATE `faculty_account` SET`acc_password`=:password WHERE acc_user_id =:faculty_id");


$query->bindParam(':password',$password);
$query->bindParam(':faculty_id',$faculty_id);
$query->execute();


	if ($query) {
		header("location:../teacher_account_settings.php");
	}

 ?>
