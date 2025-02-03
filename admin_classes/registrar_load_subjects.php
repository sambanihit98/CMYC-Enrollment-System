<?php 

include 'config.php';
   
$item_id = random_int(100000, 999999);
$load_teacher = $_POST['load_teacher'];
$load_sub_code = $_POST['load_sub_code'];
$load_sub_title = $_POST['load_sub_title'];
$load_room = $_POST['load_room'];
$load_course = $_POST['load_course'];
$load_section = $_POST['load_section']; 

$load_time_from = $_POST['load_time_from'];
$load_time_to = $_POST['load_time_to'];

$load_week = $_POST['load_week'];
$load_period = $_POST['load_period'];

$load_WEEK = strtoupper($load_week);

$LOAD_time = strtoupper($load_time_to);
$load_TIME = strtoupper($load_time_from);

$load_ROOM = strtoupper($load_room);

$load_stat = 0;



$query = $connect->prepare
("INSERT INTO `teacher_subject_load`(
	 `item_id`,
	 `load_teacher`,
	 `load_time_from`,
	 `load_time_to`,
	 `load_sub_title`,
	 `load_room`,

	 `load_section`,
	 `load_week`,
	 `load_period`,
	 `load_stat`

	) VALUES (
	:item_id,
	:load_teacher,
	:load_TIME,
	:LOAD_time,
	:load_sub_title,
	:load_ROOM,

	:load_section,
	:load_WEEK,
	:load_period,
	:load_stat

	)");


$query->bindParam(':item_id',$item_id);
$query->bindParam(':load_teacher',$load_teacher);
$query->bindParam(':load_TIME',$load_TIME);
$query->bindParam(':LOAD_time',$LOAD_time);

$query->bindParam(':load_sub_title',$load_sub_title);
$query->bindParam(':load_ROOM',$load_ROOM);

$query->bindParam(':load_section',$load_section);

$query->bindParam(':load_WEEK',$load_WEEK);

$query->bindParam(':load_period',$load_period);
$query->bindParam(':load_stat',$load_stat);

$query->execute();





 ?>