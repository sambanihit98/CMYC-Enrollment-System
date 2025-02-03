<?php 

include '../admin_classes/config.php';


$acc_user_id = $_POST['acc_user_id'];
$acc_fname = $_POST['acc_fname']; 
$acc_position = $_POST['acc_position'];


$acc_FNAME = strtoupper($acc_fname);


$query = $connect->prepare("UPDATE `faculty_account` SET 

	`acc_fname`= :acc_FNAME,
	`acc_position`= :acc_position


	 WHERE acc_user_id = :acc_user_id");


$query->bindParam(':acc_FNAME',$acc_FNAME);
$query->bindParam(':acc_user_id',$acc_user_id);
$query->bindParam(':acc_position',$acc_position);

$query->execute();



	if ($query) {
		header("location:../admin_designation_update.php?acc_user_id=$acc_user_id");
	}

 ?>



 