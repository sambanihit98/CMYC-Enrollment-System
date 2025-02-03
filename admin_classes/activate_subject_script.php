<?php

include 'config_mysqli.php';

if(isset($_POST['subject_id'])){

    $subject_id           = $_POST['subject_id'];
    $curriculum_id        = $_POST['curriculum_id'];
    $department_id        = $_POST['department_id'];
    $program_id           = $_POST['program_id'];

    $subject_code         = $_POST['subject_code'];
    $subject_description  = $_POST['subject_description'];
    $subject_year_level   = $_POST['subject_year_level'];
    $subject_semester     = $_POST['subject_semester'];

    $subject = $subject_description.' '.'('.$subject_code.')';

    //year
    if($subject_year_level == 1){
        $year_level = '1st Year';

    }else if($subject_year_level == 2){
        $year_level = '2nd Year';

    }else if($subject_year_level == 3){
        $year_level = '3rd Year';

    }else if($subject_year_level == 4){
        $year_level = '4th Year';
        
    }

    $query = mysqli_query($con, "SELECT * FROM manage_subject JOIN manage_program ON manage_subject.program_id = manage_program.program_id
        WHERE manage_subject.subject_id = '$subject_id'");
        while($row = mysqli_fetch_array($query)){
            $program_code = $row['program_code'];
        }

        //data for user log table
        $faculty_user_id  = $_POST['faculty_user_id'];
        $user_action      = 'Activated <b>'.$subject.'</b> subject on <b>'.$program_code.'</b> course (<b>'.$year_level.' - '.$subject_semester.'</b>)';
        $user_log_date    = date('Y-m-d');
        $user_log_time    = date('H:i:s');
        $zero             = 0; 

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
    
        mysqli_query($con, "UPDATE manage_subject SET subject_status = 1 WHERE subject_id = '$subject_id'");

        header("location:../registrar_manage_subject.php?department&department_id=$department_id&curriculum_id=$curriculum_id&subject=$subject&activated");
    

    
}

?>