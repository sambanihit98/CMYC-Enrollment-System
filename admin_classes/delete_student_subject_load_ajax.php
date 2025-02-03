<?php 

include 'config_mysqli.php';

if(isset($_POST['student_subject_load_id'])){
    
    $faculty_user_id         = $_POST['faculty_user_id'];
    $student_subject_load_id = $_POST['student_subject_load_id'];
    $academic_id             = $_POST['academic_id'];
    $subject_id              = $_POST['subject_id'];

        $response  = "<input type = 'text' name = 'student_subject_load_id' value = '$student_subject_load_id' hidden>";
        $response .= "<input type = 'text' name = 'academic_id'             value = '$academic_id'             hidden>";
        $response .= "<input type = 'text' name = 'subject_id'              value = '$subject_id'              hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id'         value = '$faculty_user_id'         hidden>";

    echo $response;
    exit;
}

?>