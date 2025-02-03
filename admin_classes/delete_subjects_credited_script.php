<?php

    include 'config_mysqli.php';

    $grades_report_id = $_POST['grades_report_id'];
    $student_id       = $_POST['student_id'];

    $query = mysqli_query($con, "SELECT * FROM grades_report
    JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
    JOIN student_info   ON grades_report.student_id = student_info.student_id
    WHERE grades_report.grades_report_id = '$grades_report_id'");

    while($row = mysqli_fetch_array($query)){

        //manage_subject
        $subject_code         = $row['subject_code'];
        $subject_description  = $row['subject_description'];

        //student_info
        $firstname            = ucwords($row['firstname']);
        $lastname             = ucwords($row['lastname']);
        $middlename           = ucwords($row['middlename']);
        $middle_initial       = substr($middlename, 0, 1);

        //MERGE
        $fullname = $firstname.' '.$middle_initial.'. '.$lastname;
        $subject  = $subject_code.': '.$subject_description;

    }

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_action      = 'Deleted credited subject <b>'.$subject.'</b> on <b>'.$fullname.' (Student)</b>';
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "DELETE FROM grades_report WHERE grades_report_id = '$grades_report_id'");

    header("location:../registrar_student_grades_report.php?student_id=$student_id");
?>