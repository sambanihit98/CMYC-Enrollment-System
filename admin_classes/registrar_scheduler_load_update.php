<?php 
include '../admin_classes/config.php';

$item_id = $_POST['item_id'];
$acc_user_id = $_POST['acc_user_id'];

$load_time_from = $_POST['load_time_from'];
$load_time_to = $_POST['load_time_to'];
$load_sub_title = $_POST['load_sub_title'];
$load_room = $_POST['load_room'];
$load_section = $_POST['load_section']; 
$load_week = $_POST['load_week'];


$load_period = $_POST['load_period'];


$load_WEEK = strtoupper($load_week);
$load_time_TO = strtoupper($load_time_to);
$load_time_FROM = strtoupper($load_time_from);
$load_ROOM = strtoupper($load_room);


$query = $connect->prepare("UPDATE 

	`teacher_subject_load` SET 
	`load_time_from`= :load_time_FROM,
	`load_time_to`= :load_time_TO,
	`load_sub_title`= :load_sub_title,
	`load_room`= :load_ROOM,
	`load_section`= :load_section,
	`load_week`= :load_WEEK,
	`load_period`= :load_period

	 WHERE item_id = :item_id");

$query->bindParam(':load_time_FROM',$load_time_FROM);
$query->bindParam(':load_time_TO',$load_time_TO);
$query->bindParam(':load_sub_title',$load_sub_title);
$query->bindParam(':load_ROOM',$load_ROOM);

$query->bindParam(':load_section',$load_section);
$query->bindParam(':load_WEEK',$load_WEEK);

$query->bindParam(':load_period',$load_period);

$query->bindParam(':item_id',$item_id);


$query->execute();

	if ($query) {
		header("location:../registrar_scheduler_load_update.php?acc_user_id=$acc_user_id&item_id=$item_id");
	}

 ?>