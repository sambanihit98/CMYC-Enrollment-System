<?php 
include 'config.php';

$item_id = mt_rand(100000,999999);

$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$program_code = $_POST['program_code'];
$status = $_POST['status'];
$curriculum = $_POST['curriculum']; 

//-----ACC USER ID PATTERN----//
$random = rand(100,500); //PATTERN
$day = date('d');//PATTERN
$year = date('Y');//PATTERN
$student_id = "$day-$year-$random";//PATTERN
//-----ACC USER ID PATTERN----//

$query = $connect->prepare("INSERT INTO `manage_enrollment`(`item_id`, `student_id`, `lastname`, `firstname`, `middlename`, `program_code`, `status`, `curriculum`) VALUES (:item_id, :student_id, :lastname, :firstname, :middlename, :program_code, :status, :curriculum )");

$query->bindParam(':item_id',$item_id);
$query->bindParam(':student_id',$student_id);
$query->bindParam(':lastname',$lastname);
$query->bindParam(':firstname',$firstname);
$query->bindParam(':middlename',$middlename);
$query->bindParam(':program_code',$program_code);
$query->bindParam(':status',$status);
$query->bindParam(':curriculum',$curriculum);
$query->execute();

?>