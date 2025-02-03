<?php

  session_start();
  include 'config_mysqli.php';

if(isset($_POST['new_subject_id'])){
   
  $subject_id                   = $_POST['new_subject_id'];    
      
  $new_subject_year_level       = $_POST['new_subject_year_level'];       
  $new_subject_semester         = $_POST['new_subject_semester'];        
  $new_subject_code             = $_POST['new_subject_code'];       
  $new_subject_description      = addslashes($_POST['new_subject_description']);    
  $new_subject_unit             = $_POST['new_subject_unit'];      
  $new_subject_id_prerequisite  = $_POST['new_subject_id_prerequisite'];

  $subject_desc_uc = ucwords($new_subject_description);

  $subject = $new_subject_description.' '.'('.$new_subject_code.')';

  //year
  if($new_subject_year_level == 1){
    $year_level = '1st Year';

  }else if($new_subject_year_level == 2){
      $year_level = '2nd Year';

  }else if($new_subject_year_level == 3){
      $year_level = '3rd Year';

  }else if($new_subject_year_level == 4){
      $year_level = '4th Year';
      
  }

  $query = mysqli_query($con, "SELECT * FROM manage_subject JOIN manage_program ON manage_subject.program_id = manage_program.program_id
  WHERE manage_subject.subject_id = '$subject_id'");
  while($row = mysqli_fetch_array($query)){
    $program_code = $row['program_code'];
  }
  
  //data for user log table
  $faculty_user_id  = $_POST['faculty_user_id'];
  $user_action      = 'Updated <b>'.$subject_desc_uc.' '.'('.$new_subject_code.')</b> subject on <b>'.$program_code.'</b> course (<b>'.$year_level.' - '.$new_subject_semester.'</b>)';
  $user_log_date    = date('Y-m-d');
  $user_log_time    = date('H:i:s');
  $zero             = 0; 

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "UPDATE manage_subject SET subject_code = '$new_subject_code',
                        subject_description = '$new_subject_description',
                        subject_unit = '$new_subject_unit',
                        subject_id_prerequisite = '$new_subject_id_prerequisite',
                        subject_year_level = '$new_subject_year_level',
                        subject_semester = '$new_subject_semester'
                      WHERE subject_id = '$subject_id'");


      $_SESSION['subject'] = $subject;
      echo json_encode(array("statusCode"=>200));     
}
 
?>