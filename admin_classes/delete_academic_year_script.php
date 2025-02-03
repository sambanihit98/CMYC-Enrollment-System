
<?php

include '../admin_classes/config_mysqli.php';

$academic_id      = $_POST['academic_id'];
$faculty_user_id  = $_POST['faculty_user_id'];

$query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
while($row = mysqli_fetch_array($query)){
    $academic_year_from = $row['academic_year_from'];
    $academic_year_to = $row['academic_year_to'];
    $academic_term = $row['academic_term'];

    $academic = $academic_year_from." - ".$academic_year_to." "."("."$academic_term".")";

    //data for user log table
  $user_action   = 'Deleted academic year <b>'.$academic_year_from.' - '.$academic_year_to.' '.'('.$academic_term.')</b>';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;

}

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

mysqli_query($con, "DELETE FROM academic_year WHERE academic_id = '$academic_id'");

header("location:../admin_academic.php?deleted&academic=$academic");

?>






