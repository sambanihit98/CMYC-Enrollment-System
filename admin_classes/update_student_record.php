<?php 

include '../admin_classes/config.php';

$student_id = $_POST['student_id'];

$curriculum = $_POST['curriculum'];
$item_id = $_POST['item_id'];
$description = $_POST['description'];


$query = $connect->prepare("UPDATE `student_subject_load` SET `description`=:description WHERE item_id =:item_id");


$query->bindParam(':description',$description);
$query->bindParam(':item_id',$item_id);



$query->execute();

	if ($query) {
		header("location:../update/update_student_record.php?student_id=$student_id&curriculumz=$curriculum&item_id=$item_id & description=$description");
	}


 ?>
