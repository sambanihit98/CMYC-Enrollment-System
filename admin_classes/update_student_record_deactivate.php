<?php 

$student_id = $_GET['student_id'];
$curriculumz = $_GET['curriculumz'];
$item_id = $_GET['item_id'];



    include 'config.php';

    $query = $connect->prepare("UPDATE `student_subject_load` SET `load_stat`= 1 WHERE item_id =:item_id ");

    $query->bindParam('item_id',$item_id);
    $query->execute();

    
    if ($query) {
        header("location:../registrar_student_record_evaluate.php?student_id=$student_id&curriculum=$curriculumz&item_id=$item_id");
    }


 ?>