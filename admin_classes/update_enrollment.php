<?php 

include '../admin_classes/config.php';

$item_id = $_POST['item_id'];
$student_id = $_POST['student_id'];

$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$program_code = $_POST['program_code'];
$status = $_POST['status'];
$curriculum = $_POST['curriculum'];


$query = $connect->prepare("UPDATE `manage_enrollment` SET `lastname`=:lastname,`firstname`=:firstname,`middlename`=:middlename,`program_code`=:program_code,`status`=:status,`curriculum`=:curriculum WHERE student_id = :student_id ");


$query->bindParam(':student_id',$student_id);
$query->bindParam(':lastname',$lastname);
$query->bindParam(':firstname',$firstname);
$query->bindParam(':middlename',$middlename);
$query->bindParam(':program_code',$program_code);
$query->bindParam(':status',$status);
$query->bindParam(':curriculum',$curriculum);
$query->execute();

	if ($query) {
		header("location:../update/update_enrollment.php?student_id=$student_id&item_id=$item_id");
	}

 ?>
