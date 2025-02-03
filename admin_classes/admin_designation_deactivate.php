<?php 

include '../admin_classes/config.php';


$acc_user_id = $_GET['acc_user_id'];




$query = $connect->prepare("UPDATE `faculty_account` SET 

	`acc_stat`= 1


	 WHERE acc_user_id = :acc_user_id");



$query->bindParam(':acc_user_id',$acc_user_id);


$query->execute();



	if ($query) {
		header("location:../admin_designation.php");
	}

 ?>