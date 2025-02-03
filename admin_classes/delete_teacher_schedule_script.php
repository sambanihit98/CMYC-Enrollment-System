
<?php

include 'config_mysqli.php';

$faculty_user_id = $_POST['faculty_user_id'];
$subject_load_id = $_POST['subject_load_id'];
$account_user_id = $_POST['account_user_id'];

$query = mysqli_query($con, "SELECT * FROM teacher_subject_load 
JOIN manage_subject  ON teacher_subject_load.subject_id      = manage_subject.subject_id 
JOIN manage_program  ON teacher_subject_load.program_id      = manage_program.program_id  
JOIN faculty_account ON teacher_subject_load.account_user_id = faculty_account.account_user_id  
WHERE teacher_subject_load.subject_load_id = '$subject_load_id'");

while($row = mysqli_fetch_array($query)){

    //manage_subject
    $subject_code        = $row['subject_code'];
    $subject_description = $row['subject_description'];

    //manage_program
    $program_code        = $row['program_code'];
    $program_description = $row['program_description'];

    //faculty_account 
    $account_firstname   = $row['account_firstname'];
    $account_lastname    = $row['account_lastname'];
    $account_position    = $row['account_position'];

    //teacher_subject_load
    $day_initial                = $row['day_initial'];
    $subject_section            = $row['subject_section'];
    $subject_year_level_teacher = $row['subject_year_level_teacher'];

    if($day_initial == '1Mon'){
        $day = 'Monday';
    }else if($day_initial == '2Tue'){
        $day = 'Tuesday';
    }else if($day_initial == '3Wed'){
        $day = 'Wednesday';
    }else if($day_initial == '4Thu'){
        $day = 'Thursday';
    }else if($day_initial == '5Fri'){
        $day = 'Friday';
    }else if($day_initial == '6Sat'){
        $day = 'Saturday';
    }

    //MERGE
    $fullname = $account_firstname.' '.$account_lastname.' ('.$account_position.')';
    $section  = $program_code.' - '.$subject_year_level_teacher.$subject_section;

    //data for user log table
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
    $user_action      = 'Deleted <b>'.$subject_code.': '.$subject_description.'</b> subject on <b>'.$day.'</b> schedule of <b>'.$fullname.'</b> on <b>'.$section.'</b>';

}

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

mysqli_query($con, "DELETE FROM teacher_subject_load WHERE subject_load_id = '$subject_load_id'");

header("location:../registrar_teacher_scheduler_load.php?account_user_id=$account_user_id&deleted");

?>
