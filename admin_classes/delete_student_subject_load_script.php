
<?php

include 'config_mysqli.php';

$faculty_user_id         = $_POST['faculty_user_id'];
$student_subject_load_id = $_POST['student_subject_load_id'];
$academic_id             = $_POST['academic_id'];
$subject_id              = $_POST['subject_id'];

$query = mysqli_query($con, "SELECT * FROM student_subject_load 
JOIN student_info ON student_subject_load.student_id = student_info.student_id
JOIN manage_subject ON student_subject_load.subject_id = manage_subject.subject_id
JOIN academic_year ON student_subject_load.academic_id = academic_year.academic_id
WHERE student_subject_load.student_subject_load_id = '$student_subject_load_id'");

while($row = mysqli_fetch_array($query)){

  //strudent_subject_load
  $enrollment_id  = $row['enrollment_id'];

  //student_info
  $student_id     = $row['student_id'];
  $firstname      = $row['firstname'];
  $middlename     = $row['middlename'];
  $lastname       = $row['lastname'];
  $middle_initial = substr($middlename, 0, 1);

  //manage_subject
  $subject_code        = $row['subject_code'];
  $subject_description = $row['subject_description'];

  //academic_year
  $academic_year_from  = $row['academic_year_from'];
  $academic_year_to    = $row['academic_year_to'];
  $academic_term       = $row['academic_term'];

  //MERGE
  $fullname      = $firstname.' '.$middle_initial.'. '.$lastname;
  $subject       = $subject_code.': '.$subject_description;
  $academic_year = $academic_year_from.' - '.$academic_year_to.' ('.$academic_term.')';

  //data for user log table
  $faculty_user_id  = $_POST['faculty_user_id'];
  $user_action      = 'Deleted subject <b>'.$subject.'</b> from <b>'.$fullname.' (Student)</b> subject load schedule on academic year <b>'.$academic_year.'</b>';
  $user_log_date    = date('Y-m-d');
  $user_log_time    = date('H:i:s');
  $zero             = 0;  

  mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

  mysqli_query($con, "DELETE FROM student_subject_load WHERE student_id = '$student_id' AND academic_id = '$academic_id' AND subject_id = '$subject_id'");
  mysqli_query($con, "DELETE FROM grades_report WHERE student_id = '$student_id' AND academic_id = '$academic_id' AND subject_id = '$subject_id'");

  header("location:../registrar_student_evaluation.php?enrollment_id=$enrollment_id&deleted");

}

?>
