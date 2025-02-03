<?php 
include 'config.php';

$item_id = mt_rand(100000,999999);

$student_id = $_POST['student_id'];
$description = $_POST['description'];
$load_stat = '0';

$query = $connect->prepare("INSERT INTO `student_subject_load`(`item_id`, `student_id`, `description`,`load_stat`) VALUES (:item_id, :student_id, :description, :load_stat)");

$query->bindParam(':item_id',$item_id);
$query->bindParam(':description',$description);
$query->bindParam(':student_id',$student_id);
$query->bindParam(':load_stat',$load_stat);

$query->execute();
