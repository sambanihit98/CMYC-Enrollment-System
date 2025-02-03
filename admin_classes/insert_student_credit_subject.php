
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

      $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
        while($row_subject = mysqli_fetch_array($query_subject)){
            $subject_code        = $row_subject['subject_code'];
            $subject_description = $row_subject['subject_description'];

            //MERGE
            $subject = $subject_code.': '.$subject_description;
        }

      $query = mysqli_query($con, "SELECT * FROM manage_enrollment 
        JOIN academic_year ON manage_enrollment.academic_id = academic_year.academic_id
        WHERE enrollment_id = '$enrollment_id'");

        while($row = mysqli_fetch_array($query)){

          //manage_enrollment
          $student_id         = $row['student_id'];
          $academic_id        = $row['academic_id'];
          $curriculum_id      = $row['curriculum_id'];
          $program_id         = $row['program_id'];
          $department_id      = $row['department_id'];
          $student_section    = $row['student_section'];
          $student_year_level = $row['student_year_level']; 
          
          $student_firstname  = $row['student_firstname']; 
          $student_middlename = $row['student_middlename']; 
          $student_lastname   = $row['student_lastname']; 
          $middle_initial     = substr($student_middlename, 0, 1);

          //academic_year
          $academic_year_from = $row['academic_year_from']; 
          $academic_year_to   = $row['academic_year_to']; 
          $academic_term      = $row['academic_term']; 

          //MERGE
          $fullname      = $student_firstname.' '.$middle_initial.'. '.$student_lastname;
          $academic_year = $academic_year_from.' - '.$academic_year_to.' ('.$academic_term.')';
              
        }

        //for user_log
        $user_action      = 'Credited <b>'.$subject_code.': '.$subject_description.'</b> subject to <b>'.$fullname.' (Student)</b> on academic year <b>'.$academic_year.'</b>';

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        mysqli_query($con, "INSERT INTO `grades_report`(`grades_report_id`, `student_id`, `enrollment_id`, `academic_id`, `program_id`, `subject_id`, `grades_section`, `grades_course`, `grades_year`, `prelim`, `midterm`, `final`, `average`, `remarks`) 
        VALUES ('$zero','$student_id','$enrollment_id','$academic_id','$program_id','$subject_id','$zero','$zero','$zero','$zero','$zero','$zero','$zero','Credited')");

        header("location:../registrar_student_evaluation.php?enrollment_id=$enrollment_id&credited");     
        
    } 
  }
?>



