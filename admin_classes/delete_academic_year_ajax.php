<?php 

include '../admin_classes/config_mysqli.php';

if(isset($_POST['academic_id'])){
    
    $faculty_user_id  = $_POST['faculty_user_id'];
    $academic_id      = $_POST['academic_id'];



        $response = "<input type = 'text' name = 'academic_id'     value = '$academic_id' hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
    

    echo $response;
    exit;
}

?>