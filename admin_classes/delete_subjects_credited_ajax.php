<?php 

include 'config_mysqli.php';

if(isset($_POST['grades_report_id'])){
    
    $faculty_user_id  = $_POST['faculty_user_id'];
    $grades_report_id = $_POST['grades_report_id'];
    $student_id       = $_POST['student_id'];
   
        $response =  "<input type = 'text' name = 'grades_report_id' value = '$grades_report_id' hidden>";
        $response .= "<input type = 'text' name = 'student_id'       value = '$student_id'       hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id'  value = '$faculty_user_id'  hidden>";

    echo $response;
    exit;
}

?>