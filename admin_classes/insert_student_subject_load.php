
<?php
  include 'config_mysqli.php';

  if(isset($_POST['save_subject'])){

    $checkbox_value  = $_POST['checkbox_value'];
    $enrollment_id   = $_POST['enrollment_id'];

    //data for user log table
    $faculty_user_id  = $_POST['account_user_id'];
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0; 
    
    foreach($checkbox_value as $subject_id){

      $query = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
        while($row = mysqli_fetch_array($query)){
          $student_id      = $row['student_id'];
          $academic_id     = $row['academic_id'];
          $curriculum_id   = $row['curriculum_id'];
          $program_id      = $row['program_id'];
          $department_id   = $row['department_id'];

          $student_section    = $row['student_section'];
          $student_year_level = $row['student_year_level']; 

          //------------------------------------------------------------------------------------------------------------
          //------------------------------------------------------------------------------------------------------------
          //manage_subject
          $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
          while($row_subject = mysqli_fetch_array($query_subject)){
            $subject_code        = $row_subject['subject_code'];
            $subject_description = $row_subject['subject_description'];
          }

          //------------------------------------------------------------------------------------------------------------
          //------------------------------------------------------------------------------------------------------------
          //student_info
          $query_student = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
          while($row_student = mysqli_fetch_array($query_student)){
            $firstname      = ucwords($row_student['firstname']);
            $middlename     = ucwords($row_student['middlename']);
            $lastname       = ucwords($row_student['lastname']);
            $middle_initial = substr($middlename, 0, 1);

            $fullname = $firstname.' '.$middle_initial.'. '.$lastname;
          }

          //------------------------------------------------------------------------------------------------------------
          //------------------------------------------------------------------------------------------------------------

          //user log
          $user_action  = 'Loaded subject <b>'.$subject_code.': '.$subject_description.'</b> on <b>'.$fullname.' (Student)</b>';

            mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

          //------------------------------------------------------------------------------------------------------------
          //------------------------------------------------------------------------------------------------------------

            $query1 = mysqli_query($con, "INSERT INTO `student_subject_load`(`student_subject_load_id`, `student_subject_section`, `student_subject_section_course`, `student_subject_section_year`, `enrollment_id`, `student_id`, `academic_id`, `curriculum_id`, `program_id`, `department_id`, `subject_id`) 
                                VALUES ('$zero','$student_section','$program_id','$student_year_level','$enrollment_id','$student_id','$academic_id','$curriculum_id','$program_id','$department_id','$subject_id')");
            
            $query2 = mysqli_query($con, "INSERT INTO `grades_report`(`grades_report_id`, `student_id`, `enrollment_id`, `academic_id`, `program_id`, `subject_id`, `grades_section`, `grades_course`, `grades_year`, `prelim`, `midterm`, `final`, `average`, `remarks`) 
                                VALUES ('$zero','$student_id','$enrollment_id','$academic_id','$program_id','$subject_id','$student_section','$program_id','$student_year_level','$zero','$zero','$zero','$zero','Undefined')");

            if($query1 & $query2){
              header("location:../registrar_student_evaluation.php?enrollment_id=$enrollment_id&added");
            }
              
          }

        
    } 
  }
?>


