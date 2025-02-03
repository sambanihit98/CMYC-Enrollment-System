<?php

include 'config_mysqli.php';

if(isset($_POST['save_btn'])){

  $student_id            = $_POST['student_id'];
  $academic_id           = $_POST['academic_id'];
  $department_id         = $_POST['department_id'];
  $program_id            = $_POST['program_id'];
  $curriculum_id         = $_POST['curriculum_id'];
  $student_status        = $_POST['student_status'];
  $student_year_level    = $_POST['student_year_level'];
  $student_semester      = $_POST['student_semester'];
  $student_section       = $_POST['student_section'];
  $student_type          = 'Returnee';
  $enrolled_date = date('Y-m-d');
  $enrolled_time = date('H:i:s');
  $enrollment_id = mt_rand(100000,999999);

  //-------------------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------------------
  //STUDENT
  $query_student = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
  while($row_student = mysqli_fetch_array($query_student)){
    $firstname        = $row_student['firstname'];
    $middlename       = $row_student['middlename'];
    $lastname         = $row_student['lastname'];
  }

  //COURSE
  $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
  while($row_program = mysqli_fetch_array($query_program)){
    $program_code        = $row_program['program_code'];
  }

  //ACADEMIC YEAR
  $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
  while($row_academic = mysqli_fetch_array($query_academic)){
    $academic_year_from = $row_academic['academic_year_from'];
    $academic_year_to   = $row_academic['academic_year_to'];
    $academic_term      = $row_academic['academic_term'];
  }
  //-------------------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------------------
  //MERGE
  $middle_initial = substr($middlename, 0, 1);
  $fullname       = $firstname.' '.$middle_initial.'. '.$lastname;
  $section        = $program_code.'-'.$student_year_level.$student_section;
  $academic_year  = $academic_year_from.' - '.$academic_year_to.' ('.$academic_term.')';

  //data for user log table
  $faculty_user_id  = $_POST['faculty_user_id'];
  $user_log_date    = date('Y-m-d');
  $user_log_time    = date('H:i:s');
  $zero             = 0;  
  $user_action      = 'Enrolled <b>'.$fullname.' (Returnee)</b> in <b>'.$section.'</b> for the academic year <b>'.$academic_year.'</b>';

  //-------------------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------------------
  
  //get the student's full name on student_info table
  $query_name = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
  
  while($row_name = mysqli_fetch_array($query_name)){
    $student_firstname      = $row_name['firstname'];
    $student_middlename     = $row_name['middlename'];
    $student_lastname       = $row_name['lastname'];
    $student_name_extension = $row_name['name_extension'];

     // checks in manage_enrollment table // checks with academic_id
    $query1 = mysqli_query($con, "SELECT * FROM manage_enrollment
                                  WHERE academic_id = '$academic_id'
                                  AND student_id = '$student_id'");

    //Error Duplicate on manage_enrollment table
    if (mysqli_num_rows($query1)>0){
      header("location:../reg_manage_enrollment_returnee.php?duplicate");

    }else{

      //inserts on user_log table
      mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
      VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");     

      //insert on manage_enrollment table
      mysqli_query($con, "INSERT INTO `manage_enrollment`(`enrollment_id`, `student_id`, `student_firstname`, `student_middlename`, `student_lastname`, `student_name_extension`, `academic_id`, `curriculum_id`, `program_id`, `department_id`, `student_status`, `student_type`, `student_year_level`, `student_semester`, `student_section`, `enrolled_date`, `enrolled_time`) 
                          VALUES ('$enrollment_id','$student_id','$student_firstname','$student_middlename','$student_lastname','$student_name_extension','$academic_id','$curriculum_id','$program_id','$department_id','$student_status','$student_type','$student_year_level','$student_semester','$student_section','$enrolled_date','$enrolled_time')");

      //update to new/current curriculum
      mysqli_query($con, "UPDATE student_info set curriculum_id = '$curriculum_id' WHERE student_id = '$student_id'");

      $checkbox_value = $_POST['checkbox_value'];
      foreach($checkbox_value as $subject_id){

        mysqli_query($con, "INSERT INTO `grades_report`(`grades_report_id`, `student_id`, `enrollment_id`, `academic_id`, `program_id`, `subject_id`, `grades_section`, `grades_course`, `grades_year`, `prelim`, `midterm`, `final`, `average`, `remarks`) 
                          VALUES ('$zero','$student_id','$enrollment_id','$academic_id','$program_id','$subject_id','$zero','$zero','$zero','$zero','$zero','$zero','$zero','Credited')");
      }

      header("location:../registrar_manage_enrollment.php?returnee_added");
      
    }
  }
        
}
  
?>