
<?php
  include 'config_mysqli.php';

  if(isset($_POST['save_btn'])){

    $subject_load_id = 0;

    $checkbox_value     = $_POST['checkbox_value'];

    $department_id      = $_POST['select_department'];
    $curriculum_id      = $_POST['subject_curriculum'];
    $subject_id         = $_POST['subject_title'];

    $subject_year_level = $_POST['subject_year_level'];
    $subject_semester   = $_POST['subject_semester'];

    $subject_time_from  = $_POST['subject_time_from'];
    $subject_time_to    = $_POST['subject_time_to'];
    $subject_section    = $_POST['subject_section'];
    $subject_room       = $_POST['subject_room'];

    $academic_id        = $_POST['academic_id'];
    $teacher_user_id    = $_POST['teacher_user_id'];

    
    $query_teacher = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$teacher_user_id'");
        while($row_teacher = mysqli_fetch_array($query_teacher)){
            $account_firstname = ucwords($row_teacher['account_firstname']);
            $account_lastname  = ucwords($row_teacher['account_lastname']);
            $account_position  = ucwords($row_teacher['account_position']);
            $fullname = $account_firstname.' '.$account_lastname.' ('.$account_position.')';
        }

    $query_program = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program 
    ON manage_curriculum.program_id = manage_program.program_id WHERE manage_curriculum.curriculum_id = '$curriculum_id'");
        while($row_program = mysqli_fetch_array($query_program)){
            $program_code = $row_program['program_code'];
        }

    //ex. BSIT - 1B
    $section = $program_code.' - '.$subject_year_level.$subject_section;

    //data for user log table
    $faculty_user_id  = $_POST['account_user_id'];
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
   
    foreach($checkbox_value as $day_initial){

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

        //Duplicate ID. Please try again!
        //$query_primary_key = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_load_id = '$subject_load_id'");

        //NSTP subject
        $query_nstp = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
        while($row_nstp = mysqli_fetch_array($query_nstp)){
            $subject_code        = $row_nstp['subject_code'];
            $subject_description = $row_nstp['subject_description'];
        }

        //for user_log
        $user_action      = 'Loaded <b>'.$subject_code.': '.$subject_description.'</b> subject on <b>'.$day.'</b> schedule for <b>'.$fullname.'</b> on <b>'.$section.'</b>';

        //Scheduled time has already been taken!
        $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
        WHERE subject_time_from = '$subject_time_from' 
        AND account_user_id = '$teacher_user_id'
        AND subject_time_to = '$subject_time_to'
        AND day_initial = '$day_initial'
        AND academic_id = '$academic_id'");

        //Conflict time schedule! Please try again!
        $query2 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE day_initial = '$day_initial' 
        AND account_user_id = '$teacher_user_id' AND academic_id = '$academic_id' 
        AND ((subject_time_from >= '$subject_time_from' AND subject_time_from < '$subject_time_to')
            OR (subject_time_to > '$subject_time_from'  AND subject_time_to <= '$subject_time_to')
        OR ('$subject_time_from' >= subject_time_from AND '$subject_time_from' < subject_time_to)
            OR ('$subject_time_to' > subject_time_from AND '$subject_time_to' <= subject_time_to))");

        //Room and time schedule already take!
        $query3 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE day_initial = '$day_initial' 
        AND subject_room = '$subject_room' AND academic_id = '$academic_id'
        AND ((subject_time_from >= '$subject_time_from' AND subject_time_from < '$subject_time_to')
            OR (subject_time_to > '$subject_time_from'  AND subject_time_to <= '$subject_time_to')
        OR ('$subject_time_from' >= subject_time_from AND '$subject_time_from' < subject_time_to)
            OR ('$subject_time_to' > subject_time_from AND '$subject_time_to' <= subject_time_to))");

        //Subject has already assigned to a teacher on that section!
        $query4 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE academic_id = '$academic_id'
        AND curriculum_id = '$curriculum_id'
        AND subject_section = '$subject_section'
        AND subject_year_level_teacher = '$subject_year_level'
        AND subject_id = '$subject_id'
        AND account_user_id != '$teacher_user_id'");

        //--------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------

        //if(mysqli_num_rows($query_primary_key)>0){
            //print "Duplicate ID. Please try again!";

        //NSTP subject
        if(strpos($subject_code, 'NSTP') !== false){

            $query_program_department = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
            while($row = mysqli_fetch_array($query_program_department)){
                $program_id     = $row['program_id'];
                $department_id  = $row['department_id'];

                mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
            
                $sql = "INSERT INTO `teacher_subject_load`(`subject_load_id`, `academic_id`, `account_user_id`, `subject_id`, `curriculum_id`, `program_id`, `department_id`, `day_initial`, `subject_time_from`, `subject_time_to`, `subject_room`, `subject_section`, `subject_year_level_teacher`) 
                                VALUES ('$subject_load_id','$academic_id','$teacher_user_id','$subject_id','$curriculum_id','$program_id','$department_id','$day_initial','$subject_time_from','$subject_time_to','$subject_room','$subject_section','$subject_year_level')";
            
                    if (mysqli_query($con, $sql)) {
                        header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&added");
                
                    } else {
                        header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error");
                    }
        
            }

        //Scheduled time has already been taken!
        //error 101
        }else if(mysqli_num_rows($query1)>0){
            header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error_101");
       
        //Invalid time schedule! Please try again!
        //error 102
        }else if($subject_time_from > $subject_time_to){
            header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error_102");

        //Subject has already assigned to a teacher on that section!
        //error 103
        }else if(mysqli_num_rows($query4)>0){
            header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error_103");

        //Conflict time schedule! Please try again!
        //error 104
        }else if(mysqli_num_rows($query2)>0){
            header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error_104");

        //Room and time schedule already take!
        //error 105
        }else if(mysqli_num_rows($query3)>0){
            header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error_105");

        }else{

            $query_program_department = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
            while($row = mysqli_fetch_array($query_program_department)){
                $program_id     = $row['program_id'];
                $department_id  = $row['department_id'];

                mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
            
                $sql = "INSERT INTO `teacher_subject_load`(`subject_load_id`, `academic_id`, `account_user_id`, `subject_id`, `curriculum_id`, `program_id`, `department_id`, `day_initial`, `subject_time_from`, `subject_time_to`, `subject_room`, `subject_section`, `subject_year_level_teacher`) 
                                VALUES ('$subject_load_id','$academic_id','$teacher_user_id','$subject_id','$curriculum_id','$program_id','$department_id','$day_initial','$subject_time_from','$subject_time_to','$subject_room','$subject_section','$subject_year_level')";
            
                    if (mysqli_query($con, $sql)) {
                        header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&added");
                
                    } else {
                        header("location:../registrar_teacher_scheduler_load.php?account_user_id=$teacher_user_id&error");
                    }
        
            }

        }
        
    } 
    
  }
?>




