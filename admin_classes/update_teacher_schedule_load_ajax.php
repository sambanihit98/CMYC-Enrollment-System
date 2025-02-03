<?php
  include 'config_mysqli.php';

  if(isset($_POST['subject_load_id'])){

    $teacher_user_id        = $_POST['teacher_user_id'];
    $academic_id            = $_POST['academic_id'];
    $subject_load_id        = $_POST['subject_load_id'];

    $new_subject_day        = $_POST['new_subject_day'];
    $new_subject_time_from  = $_POST['new_subject_time_from'];
    $new_subject_time_to    = $_POST['new_subject_time_to'];
    $new_subject_section    = $_POST['new_subject_section'];
    $new_subject_room       = $_POST['new_subject_room'];

    //check for teachers that assigned to the same subject and same section
    $curriculum_id              = $_POST['curriculum_id'];
    $subject_year_level_teacher = $_POST['subject_year_level_teacher'];
    $subject_id                 = $_POST['subject_id'];

    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------

    if($new_subject_day == '1Mon'){
      $day = 'Monday';
    }else if($new_subject_day == '2Tue'){
        $day = 'Tuesday';
    }else if($new_subject_day == '3Wed'){
        $day = 'Wednesday';
    }else if($new_subject_day == '4Thu'){
        $day = 'Thursday';
    }else if($new_subject_day == '5Fri'){
        $day = 'Friday';
    }else if($new_subject_day == '6Sat'){
        $day = 'Saturday';
    }

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

    $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
      while($row_subject = mysqli_fetch_array($query_subject)){
          $subject_code        = $row_subject['subject_code'];
          $subject_description = $row_subject['subject_description'];
      }

    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------

    //ex. BSIT - 1B
    $section = $program_code.' - '.$subject_year_level_teacher.$new_subject_section;

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
    $user_action      = 'Updated <b>'.$subject_code.': '.$subject_description.'</b> subject on <b>'.$day.'</b> schedule for <b>'.$fullname.'</b> on <b>'.$section.'</b>';

    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------

    //Scheduled time has already been taken!
    $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                    WHERE subject_load_id != '$subject_load_id'
                                    AND subject_time_from = '$new_subject_time_from' 
                                    AND account_user_id = '$teacher_user_id'
                                    AND subject_time_to = '$new_subject_time_to'
                                    AND day_initial = '$new_subject_day'
                                    AND academic_id = '$academic_id'");

    //Conflict time schedule! Please try again!
    /*$query2 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                  WHERE day_initial = '$new_subject_day'
                                  AND account_user_id = '$teacher_user_id' 
                                  AND academic_id = '$academic_id' 
                                  AND subject_load_id != '$subject_load_id'
                                  AND ((subject_time_from BETWEEN '$new_subject_time_from' AND '$new_subject_time_to' 
                                      OR subject_time_to BETWEEN '$new_subject_time_from' AND '$new_subject_time_to') 
                                  OR ('$new_subject_time_from' BETWEEN subject_time_from AND subject_time_to 
                                      OR '$new_subject_time_to' BETWEEN subject_time_from AND subject_time_to))");*/

    $query2 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                  WHERE day_initial = '$new_subject_day' 
                                  AND account_user_id = '$teacher_user_id' 
                                  AND academic_id = '$academic_id' 
                                  AND subject_load_id != '$subject_load_id'
                                  AND ((subject_time_from >= '$new_subject_time_from' AND subject_time_from < '$new_subject_time_to')
                                      OR (subject_time_to > '$new_subject_time_from'  AND subject_time_to <= '$new_subject_time_to')
                                  OR ('$new_subject_time_from' >= subject_time_from AND '$new_subject_time_from' < subject_time_to)
                                      OR ('$new_subject_time_to' > subject_time_from AND '$new_subject_time_to' <= subject_time_to))");

    //Room and time schedule already take!
    /*$query3 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                  WHERE day_initial = '$new_subject_day' 
                                  AND subject_room = '$new_subject_room' 
                                  AND academic_id = '$academic_id'
                                  AND subject_load_id != '$subject_load_id'
                                  AND ((subject_time_from BETWEEN '$new_subject_time_from' AND '$new_subject_time_to' 
                                      OR subject_time_to BETWEEN '$new_subject_time_from' AND '$new_subject_time_to') 
                                  OR ('$new_subject_time_from' BETWEEN subject_time_from AND subject_time_to 
                                      OR '$new_subject_time_to' BETWEEN subject_time_from AND subject_time_to))");*/

    $query3 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                  WHERE day_initial = '$new_subject_day' 
                                  AND subject_room = '$new_subject_room' 
                                  AND academic_id = '$academic_id'
                                  AND subject_load_id != '$subject_load_id'
                                  AND ((subject_time_from >= '$new_subject_time_from' AND subject_time_from < '$new_subject_time_to')
                                      OR (subject_time_to > '$new_subject_time_from'  AND subject_time_to <= '$new_subject_time_to')
                                  OR ('$new_subject_time_from' >= subject_time_from AND '$new_subject_time_from' < subject_time_to)
                                      OR ('$new_subject_time_to' > subject_time_from AND '$new_subject_time_to' <= subject_time_to))");

    //Subject has already assigned to a teacher on that section!
    $query4 = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                  WHERE academic_id = '$academic_id'
                                  AND curriculum_id = '$curriculum_id'
                                  AND subject_section = '$new_subject_section'
                                  AND subject_year_level_teacher = '$subject_year_level_teacher'
                                  AND subject_id = '$subject_id'
                                  AND account_user_id != '$teacher_user_id'
                                  AND subject_load_id != '$subject_load_id'"); 


//Scheduled time has already been taken!
      if (mysqli_num_rows($query1)>0){
        echo json_encode(array("statusCode"=>201));

      //Invalid time schedule! Please try again!
      }else if($new_subject_time_from > $new_subject_time_to){
        echo json_encode(array("statusCode"=>202));

      //Subject has already assigned to a teacher on that section!
      }else if(mysqli_num_rows($query4)>0){
        echo json_encode(array("statusCode"=>205));

      //Conflict time schedule! Please try again!
      }else if(mysqli_num_rows($query2)>0){
          echo json_encode(array("statusCode"=>203));

      //Room and time schedule already take!
      }else if(mysqli_num_rows($query3)>0){
          echo json_encode(array("statusCode"=>204));

      }else{

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        mysqli_query($con, "UPDATE teacher_subject_load SET day_initial = '$new_subject_day',
                                                            subject_time_from = '$new_subject_time_from',
                                                            subject_time_to = '$new_subject_time_to',
                                                            subject_section = '$new_subject_section',
                                                            subject_room = '$new_subject_room'
                                                        WHERE subject_load_id = '$subject_load_id'");
        echo json_encode(array("statusCode"=>200));
      }


  }
?>